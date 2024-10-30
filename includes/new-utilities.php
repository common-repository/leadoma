<?php
function leadomaCreateTag($title, $color_code) {
  $LEADOMA_API = new LEADOMA_API();

  $data = array(
    "title" => $title,
    "color_code" => $color_code,
  );

  $res = $LEADOMA_API->post(LEADOMA_BASE_URL . "/business/tag", $data);
  return ($res["status"] == 200 || $res["status"] == 200) ? $res["body"]["tag"]["slug"] : null;
}

function leadomaGetTags() {
  $LEADOMA_API = new LEADOMA_API();
  $res = $LEADOMA_API->get(LEADOMA_BASE_URL . "/business/tag");
  return $res["status"] == 200 ? $res["body"]["tags"] : null;
}
function leadomaGetTagSlug($tagName, $defaultColorCode = "black") {
  $tags = leadomaGetTags();
  if (!$tags) {
    return null;
  }

  foreach ($tags as $tag) {
    if ($tag["title"] == $tagName) {
      return $tag["slug"];
    }
  }

  return leadomaCreateTag($tagName, $defaultColorCode);
}
