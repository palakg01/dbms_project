<?php
  session_start();
  
  include './db.php';
  include './../config.php';
  $con = createDB();

  $apiKey = $keyId;
  $payment_amount = $_SESSION['payable_amount'];
  $train_no = $_SESSION['train_no'];
  $ticket_id = 'trn'.rand(1111111,99999999).'TKT';
  $_SESSION['ticket_id'] = $ticket_id;

?>

<script 
  src="https://code.jquery.com/jquery-3.6.0.min.js" 
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" 
  crossorigin="anonymous">
</script>

<form action="ticket.php" method="POST">
<script
    src="https://checkout.razorpay.com/v1/checkout.js"
    data-key="<?php echo $apiKey; ?>" 
    data-amount="<?php echo $payment_amount*100 ?>" 
    data-currency="INR"
    data-id="
    <?php 
      $order_id = 'OID'.rand(1111111,99999999).'TKT';
      $_SESSION['order_id'] = $order_id;
      echo $order_id;
    ?>"
    data-buttontext="Pay with Razorpay" 
    data-name="IRCTC Train Services"
    data-description="Train Ticket Payment"
    data-image="https://example.com/your_logo.jpg"
    data-prefill.email="<?php $_SESSION['email'] ?>"
></script>

<script type="text/javascript">
    $(document).ready(function() {
        $("input[class=razorpay-payment-button]").click();
    });
</script>
<input type="hidden" custom="Hidden Element" name="hidden">
</form>