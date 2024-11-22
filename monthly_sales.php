<?php
  $page_title = 'Monthly Sales';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php
 $year = date('Y');
 $sales = monthlySales($year);
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Monthly Sales</span>
        </strong>
      </div>
      <div class="panel-body">
        <!-- Sales Table -->
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th class="text-center" style="width: 50px;">#</th>
              <th> Product name </th>
              <th class="text-center" style="width: 15%;"> Quantity sold</th>
              <th class="text-center" style="width: 15%;"> Total </th>
              <th class="text-center" style="width: 15%;"> Date </th>
           </tr>
          </thead>
         <tbody>
           <?php foreach ($sales as $sale):?>
           <tr>
             <td class="text-center"><?php echo count_id();?></td>
             <td><?php echo remove_junk($sale['name']); ?></td>
             <td class="text-center"><?php echo (int)$sale['qty']; ?></td>
             <td class="text-center"><?php echo remove_junk($sale['total_saleing_price']); ?></td>
             <td class="text-center"><?php echo $sale['date']; ?></td>
           </tr>
           <?php endforeach;?>
         </tbody>
       </table>

       <!-- Sales Chart -->
       <canvas id="salesChart" width="400" height="200"></canvas>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Prepare data for the chart
  const salesData = <?php echo json_encode($sales); ?>;
  const labels = salesData.map(sale => sale.date);
  const quantities = salesData.map(sale => parseInt(sale.qty));
  const totals = salesData.map(sale => parseFloat(sale.total_saleing_price));

  // Chart configuration
  const ctx = document.getElementById('salesChart').getContext('2d');
  const salesChart = new Chart(ctx, {
    type: 'bar', // Change to 'line' for a line chart
    data: {
      labels: labels,
      datasets: [
        {
          label: 'Quantity Sold',
          data: quantities,
          backgroundColor: 'rgba(54, 162, 235, 0.5)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1
        },
        {
          label: 'Total Sales',
          data: totals,
          backgroundColor: 'rgba(75, 192, 192, 0.5)',
          borderColor: 'rgba(75, 192, 192, 1)',
          borderWidth: 1
        }
      ]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'top',
        },
        title: {
          display: true,
          text: 'Monthly Sales Data'
        }
      },
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>

<?php include_once('layouts/footer.php'); ?>