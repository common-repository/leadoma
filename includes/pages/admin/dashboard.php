<?php wp_enqueue_script("leadoma-chartjs"); ?>

<script src="<?php echo LEADOMA_DIR_URL . "admin/js/dashboard/chart.js" ?>"></script>

<div class="leadoma">
  <div class="container-fluid">
    <div class="row">
      <?php
      $res = leadoma_get_user();
      $info = null;
      if ($res["status"] == 200) {
        $info = $res["body"];
      }
      $email_verified = true;
      $name = $email = "";
      $verificationDetail = "";

      if (isset($_GET["detail"])) {
        $verificationDetail = sanitize_text_field($_GET["detail"]);
      }

      if ($info) {
        $name = $info["full_name"];
        $email = $info["email"];
        $email_verified = $info["email_verified"];
        // update user email
        leadomaSetOption("current_user_email", $email);
      }
      ?>
      <div class="col-12 page-title">Dashboard

        <?php
        if ($info) {
          if (get_option("leadoma_access_token")) { ?>
            <button type="submit" class="btn btn-primary btn-sm float-end me-2" onclick="logoutAndRedirect()">Logout</button>
            <?php
            if (!$email_verified) { ?>
              <button type="submit" class="btn btn-primary btn-sm float-end me-2" onclick="sendEmailVerificationRequest(this)">Send email verification</button>
            <?php
            }
          } else {
            ?>
            <button type="submit" class="btn btn-primary btn-sm float-end me-2" onclick="leadomaRedirectTo('leadoma-login')">Login</button>
          <?php
          }
          // syncing status
          $isSyncingCompleted = leadomaHandlePageLoadSyncChecking();
          ?>
          <button type="submit" style="<?php echo !$isSyncingCompleted ? '' : 'display:none' ?>" class="btn btn-primary btn-sm float-end me-2 lm-spinning-icon position-relative lm-syncing" disabled>Syncing <img height="10" src="<?php echo LEADOMA_DIR_URL ?>admin/images/icons/spin.svg" alt=""> <span class="lm-tooltip">It might take a while, feel free to leave the page</span></button>
          <button type="submit" style="<?php echo ($isSyncingCompleted && !empty(leadomaGetUnsyncedUsers())) ? '' : 'display:none' ?>" class="btn btn-primary btn-sm float-end me-2 lm-sync" onclick="leadomaSyncUnsuncedCustomers()">Sync unsynced users</button>
          <button type="submit" style="<?php echo ($isSyncingCompleted && empty(leadomaGetUnsyncedUsers())) ? '' : 'display:none' ?>" class="btn btn-primary btn-sm float-end me-2 lm-synced" disabled>All users have been synced</button>
        <?php
        }
        ?>
      </div>
    </div>

    <?php
    $res = leadoma_get_stats();
    $stats = null;
    if ($res["status"] == 200) {
      $stats = $res["body"];
    }
    if ($stats) {
      $customerCount = $stats["data"]["business"]["stats"]["customers_count"];
      $ordersCount = $stats["data"]["business"]["stats"]["orders_count"];
      $submitsCount = $stats["data"]["business"]["stats"]["submits_count"];
      $transactionsAmount = $stats["data"]["business"]["stats"]["transactions_amount"];
      $charts = $stats["data"]["business"]["charts"];
      $dailyCharts = $charts["daily"];
      $monthlyCharts = $charts["monthly"];

      $newCustomers = $dailyCharts["customers_count"][0]["value"] ?? 0;
      $newOrders = $dailyCharts["orders_count"][0]["value"] ?? 0;


      $customersMonths = count($monthlyCharts["customers_count"]);
      $ordersMonths = count($monthlyCharts["orders_count"]);
      $customersMonths = $customersMonths>0?$customersMonths:1;
      $ordersMonths = $ordersMonths>0?$ordersMonths:1;

      $monthlyCustomers = 0;
      $monthlyOrders = 0;
      foreach ($monthlyCharts["customers_count"] as $customer) {
        $monthlyCustomers += $customer["value"];
      }
      foreach ($monthlyCharts["orders_count"] as $order) {
        $monthlyOrders += $order["value"];
      }


      $avgMonthlyCustomers = $monthlyCustomers / $customersMonths;
      $avgMonthlyOrders = $monthlyOrders / $ordersMonths;
    ?>
      <div class="row lm-dashboard">
        <div class="col-7 mt-3">
          <div class="lm-user-info">
            <span class="lm-profile"><?php echo get_avatar($email)?></span>
            <div>
              <h2>Hi <?php echo $name ? esc_html($name) : "" ?></h2>
              <?php
              $hour = date('H');
              $dayTerm = ($hour > 17) ? "Evening" : (($hour > 12) ? "Afternoon" : "Morning");
              ?>
              <p>Good <?php echo esc_html($dayTerm) ?>...</p>
            </div>
          </div>

          <div class="lm-overview">
            <div class="lm-card-title">Stats overview</div>
            <div class="lm-card-tabs">
              <!-- <div class="active">Day</div>
              <div>Month</div> -->
              <!-- <div>Year</div>
              <div>All</div> -->
            </div>
            <div class="lm-charts lm-is-monthly">
              <div class="overview-info">
                <div>
                  <div>Monthly customers</div>
                  <div class="value"><?php echo esc_html($monthlyCustomers) ?></div>
                  <!-- <div class="value"><?php echo esc_html($customerCount) ?></div> -->
                </div>
                <div class="lm-monthly">
                  <canvas id="lm-customers-monthly-chart" style="width: 120px; max-height:30px"></canvas>
                  <div id="lm-customers-monthly-chart-percent" class="text-center" style="color: #ff6d6a; font-weight: bold"></div>
                </div>
                
              </div>

              <div class="overview-info">
                <div>
                  <div>Monthly orders</div>
                  <div class="value"><?php echo esc_html($monthlyOrders) ?></div>
                  <!-- <div class="value"><?php echo esc_html($ordersCount) ?></div> -->
                </div>
                <div class="lm-monthly">
                  <canvas id="lm-orders-monthly-chart" style="width: 120px; max-height:30px"></canvas>
                  <div id="lm-orders-monthly-chart-percent" class="text-center" style="color: #ff6d6a; font-weight: bold"></div>
                </div>
                
                
              </div>

              <div class="overview-info">
                <div>
                  <div>New customers</div>
                  <div class="value"><?php echo esc_html($newCustomers) ?></div>
                </div>
                <div class="lm-daily">
                  <canvas id="lm-customers-daily-chart" style="width: 120px; max-height:30px"></canvas>
                  <div id="lm-customers-daily-chart-percent" class="text-center" style="color: #ff6d6a; font-weight: bold"></div>
                </div>
              </div>
              <div class="overview-info">
                <div>
                  <div>New orders</div>
                  <div class="value"><?php echo esc_html($newOrders) ?></div>
                </div>
                <div class="lm-daily">
                  <canvas id="lm-orders-daily-chart" style="width: 120px; max-height:30px"></canvas>
                  <div id="lm-orders-daily-chart-percent" class="text-center" style="color: #ff6d6a; font-weight: bold"></div>
                </div>
              </div>
              <div class="overview-info">
                <div>
                  <div>Avg. monthly customers</div>
                  <div class="value"><?php echo esc_html($avgMonthlyCustomers) ?></div>
                </div>
              </div>


              <div class="overview-info">
                <div>
                  <div>Avg. monthly orders</div>
                  <div class="value"><?php echo esc_html($avgMonthlyOrders) ?></div>
                </div>
              </div>
              <!-- <div class="overview-info">
                <div>
                  <div>Payments received</div>
                  <div class="value">-</div>
                </div>
              </div> -->
            </div>
          </div>
        </div>

        <div class="col-5">

        </div>
      </div>
    <?php } ?>
    <?php
    if ($verificationDetail) {
      echo "<h5 class='text-center'>" . esc_html($verificationDetail) . "</h5>";
    }
    // if ($name) {
    //   echo "<h4>Name: " . esc_html($name) . "</h4>";
    //   echo "<h4>Email: " . esc_html($email) . "</h4>";
    // }


    if (!$info || !$stats) {
      echo "<h2 class='text-center mt-4'>Connection error! try refreshing the page</h2>";
    }
    ?>

  </div>


  <div>
    <script>
      let lm_options = {
        tooltips: {
          enabled: false
        },
        hover: {
          mode: null
        },
        plugins: {
          legend: {
            display: false
          },
        },
        animation: {
          duration: 0,
        },
        scales: {
          x: {
            grid: {
              display: false
            },
            ticks: {
              display: false
            },
            display: false,
          },
          y: {
            grid: {
              display: false
            },
            ticks: {
              display: false
            },
            display: false,
          }
        }
      };

      const monthlyCharts = <?php echo json_encode($monthlyCharts) ?>;
      const dailyCharts = <?php echo json_encode($dailyCharts) ?>;

      const lmChartsJs = [
        {
          id: "lm-customers-daily-chart",
          title: "Daily Customers",
          data: dailyCharts.customers_count.map((item, index) => {return {x:index, y:item.value}})
        },
        {
          id: "lm-orders-daily-chart",
          title: "Daily Orders",
          data: dailyCharts.orders_count.map((item, index) => {return {x:index, y:item.value}})
        },
        {
          id: "lm-orders-monthly-chart",
          title: "Monthly Orders",
          data: monthlyCharts.orders_count.map((item, index) => {
            return {
              x: index,
              y: item.value
            }
          })
        },
        {
          id: "lm-customers-monthly-chart",
          title: "Monthly Customers",
          data: monthlyCharts.customers_count.map((item, index) => {
            return {
              x: index,
              y: item.value
            }
          })
        },
      ]

      lmChartsJs.forEach(chart => {
        if (chart.data.length >= 2) {
          const lmCustomersChart = document.getElementById(chart.id).getContext("2d");
          let percent = 0;
          if (chart.data.at(-2) && chart.data.at(-1)) {
            percent = 100 * (chart.data.at(-2).y - chart.data.at(-1).y) / chart.data.at(-2).y;
          }
          percent = Math.round(percent);
          document.getElementById(`${chart.id}-percent`).innerText = percent >= 100 ? `+${percent-100} %` : `-${percent} %`;
          new Chart(lmCustomersChart, {
            type: 'scatter',
            data: {
              datasets: [{
                label: chart.title,
                data: chart.data,
                fill: false,
                showLine: true,
                borderColor: chart.data.at(-1)?.y > chart.data.at(-2)?.y ? '#A2E4B8' : '#FF6D6A',
                pointRadius: 0,
                cubicInterpolationMode: 'monotone'
              }]
            },
            options: lm_options
          });
        }
      });
    </script>
  </div>
</div>