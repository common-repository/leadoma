<?php
function leadomaSanitizeArray($raw_array) {
  return array_map(function ($value) {
    if (is_string($value)) {
      return sanitize_text_field($value);
    }

    if (is_int($value)) {
      return intval($value);
    }

    if (is_bool($value)) {
      return boolval($value);
    }

    if (is_array($value)) {
      return leadomaSanitizeArray($value);
    }

  }, $raw_array);
}

function leadomaGetOption($name) {
  $options = get_option("leadoma");
  if (empty($options)) {
    return false;
  } else {
    if (array_key_exists($name, $options)) {
      return $options[$name];
    } else {
      return null;
    }
  }
}

function leadomaSetOption($name, $value) {
  $options = get_option("leadoma");
  if (empty($options)) {
    $options = array();
  }
  $options[$name] = $value;
  update_option("leadoma", $options);
}

function leadomaUpdateSyncOption($req_slug, $usersIds, $username, $syncingInProgress = true) {

  $syncedOption = leadomaGetOption("sync_process");
  if (empty($syncedOption)) {
    $syncedOption = array();
  }

  $syncedOption[$req_slug] = array(
    "syncing" => $syncingInProgress,
    "origin" => $username,
    "users" => $usersIds,
  );

  leadomaSetOption("sync_process", $syncedOption);

}

function leadomaIsSyncingInProcess() {
  $syncs = leadomaGetOption("sync_process");
  if (!$syncs || empty($syncs)) {
    return false;
  }

  foreach ($syncs as $processId => $isInProcess) {
    if ($isInProcess["syncing"]) {
      return $processId;
    }
  }
  return false;
}

function leadomaGetUnsyncedUsers() {
  $args = array(
    'fields' => array('ID', 'user_login', 'user_email', 'first_name', 'last_name'),
    'number' => -1,
    'meta_query' => array(
      'relation' => 'OR',
      array(
        'key' => 'is_in_leadoma_' . getCurrentUserEmail(),
        'compare' => 'NOT EXISTS',
      ),
      array(
        'key' => 'is_in_leadoma_' . getCurrentUserEmail(),
        'value' => false,
      ),
    ),

  );
  $user_query = new WP_User_Query($args);
  $users = $user_query->get_results();
  if (empty($users)) {
    return array();
  }
  $usersWithAdditional = array();
  $usersIds = array();
  foreach ($users as $user) {
    $meta = get_user_meta($user->ID);

    $phonenumber = DEFAULT_VALUES['customer']['phone_number'];
    if (array_key_exists("billing_phone", $meta)) {
      $phonenumber = $meta["billing_phone"][0];
    }

    array_push($usersIds, $user->ID);
    array_push($usersWithAdditional,
      array(
        "full_name" => $user->user_login,
        "email" => $user->user_email,
        "phone_number" => $phonenumber,
        "country" => DEFAULT_VALUES['customer']['country'],
        "city" => DEFAULT_VALUES['customer']['city'],
        "language" => DEFAULT_VALUES['customer']['language'],
        "company" => DEFAULT_VALUES['customer']['company'],
        "website" => DEFAULT_VALUES['customer']['website'],
        "tags" => array(
          DEFAULT_VALUES['customer']['tags']["default"],
        ),
      )
    );
  }

  return array(
    "ids" => $usersIds,
    "users" => array(
      "customers_data" => $usersWithAdditional,
    ),
  );
}

function leadomaUpdateSyncedUsers($syncId, $username, $customerIds) {
  $syncedOption = leadomaGetOption("sync_process");
  $usersIds = $syncedOption[$syncId]["users"];
  $index = 0;
  foreach ($usersIds as $userId) {
    update_user_meta($userId, 'is_in_leadoma_' . getCurrentUserEmail(), true);
    // todo update another user meta to add the customer code, for auto tags
    update_user_meta($userId, 'leadoma_id_' . getCurrentUserEmail(), $customerIds[$index]);
    $index++;

  }
  leadomaUpdateSyncOption($syncId, $usersIds, $username, false);
}
function getCurrentUserEmail() {
  return leadomaGetOption("current_user_email");
}
