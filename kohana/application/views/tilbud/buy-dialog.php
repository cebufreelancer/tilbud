<?php
$newprice = $deal['regular_price'] - ($deal['regular_price']*($deal['discount']/100) );
?>
<div style="display:none">
	<div id="buy-dialog" >
	  <div id="message-payment" style="background-color: #1F6284">
  	  <div id="pay_box" class="pay_box" style=" border: solid 0px #000; height: 373px; overflow: hidden;">

  	    <div id="div_flow_steps" style="height: 40px; background-color: #1A5370">
  	      <ul style="list-style-type: none">
  	        <li style="color: white; float: left; padding: 10px 10px">1. Personlige oplysninger</li>
  	        <li style="color: gray; float: left; padding: 10px 10px">2. Betaling</li>
  	        <li style="color: gray; float: left; padding: 10px 10px">3. Kvittering</li>
  	      </ul>
        </div>
  
        <form action="https://www.moneybookers.com/app/payment.pl"  name="payment-form" id="payment-form" method="post" target="content">
          
          <input type="hidden" name="title" value="<?php echo $deal['title'];?>">
          <input type="hidden" name="id" value="<?php echo $deal['ID'];?>">
          <input type="hidden" id="pricepcs" name="pricepcs" value="<?php echo $newprice;?>">
          <input type="hidden" name="end_date" value="<?php echo $deal['end_date'];?>">

          <input type="hidden" name="recipient_description" value="Tilbudibyen">
          <input type="hidden" name="return_url_text" value="Return to TilbudIbyen">
          <input type="hidden" name="return_url" value="http://www.tilbudibyen.com">
          
          <input type="hidden" name="status_url" value="michaxze@gmail.com"> 
          <input type="hidden" name="language" value="DE">
          <input type="hidden" name="currency" value="DKK">
          <input type="hidden" name="detail1_description" value="<?php echo mb_convert_encoding(html_entity_decode($deal['title']), "ISO_8859-1", "UTF-8");?>">
          <input type="hidden" name="detail1_text" value="<?php echo mb_convert_encoding(html_entity_decode($deal['contents_title']), "ISO_8859-1", "UTF-8");?>">

<input type="hidden" name="pay_to_email" value="info@tilbudibyen.dk">
 <input type="hidden" name="return_url" value="http://www.tilbudibyen.comm/payment_success"> <!-- URL to redirect after payment success -->
 <input type="hidden" name="cancel_url" value="http://www.tilbudibyen.com">  <!-- URL to redirect after payment cancel -->
 <input type="hidden" name="status_url" value="http://www.tilbudibyen.com/payment_response"> <!-- URL to get the payment response (not visible to user, called on backend) -->
 <input type="hidden" name="language" value="DK"> <!-- Language of payment -->
 
 <input type="hidden" name="hide_login" value="1">  <!-- Whether to show the tiny login form with the payment form, no in our case -->
 
 <!-- Specifies a target in which the return_url value will be called upon successful payment from customer.  -->
 <!-- 1 = '_top', 2 = '_parent', 3 = '_self', 4= '_blank' -->
 <input type="hidden" name="return_url_target" value="1"> 
 <input type="hidden" name="cancel_url_target" value="1">
 
 <!-- Custom fields for your own needs -->
 
 <input type="hidden" name="confirmation_note" value="Thanks for purchasing at TilbudIbyen"> <!-- Confirmation message to be shown after payment has been made -->

          <table border="0" cellpadding="0" cellspacing="0" style=" margin-top: 15px; margin-left: auto; margin-right: auto;">
            <tbody><tr>
              <td style="width: 720px; height: 315px; background: #f5f5f5; overflow: auto;">
                <div id="div_content" style="display: none;"><iframe name="content" id="content" style="height: 315px; width: 720px; border: solid 0px #ff0000; overflow: auto;" scrolling="yes"></iframe></div>
                <div id="infobox" style="padding: 10px; border: solid 0px #ff0000;">
                  <div style="font-size: 10pt;">
                    Antal <select name="qty" style="padding-bottom: 3px; color: #515151; border: solid 1px #686868; font-size: 12pt; padding-bottom: 3px; color: #515151; border: solid 1px #686868;" 
                    onchange="computeTotal(this);">
                      <?php
                      for($i=1; $i<=$deal['max_buy']; $i++) {
                      ?>
                      <option value="<?php echo $i;?>"><?php echo $i;?></option>
                      <?php } ?>
                      </select>
                      &nbsp; &nbsp;x kr. <?php echo $newprice;?>&nbsp; &nbsp;<span style="font-weight: bold;">Total kr. </span>
                      <input type="text" id="amount" name="amount" value="<?php echo $newprice;?>" style="border: none; background: none; font-weight: bold; width: 100px;" readonly="">
                      <br><br>
                      <div style="padding-bottom: 0px;">
                        <input type="text" id="pay_from_email" name="pay_from_email" style="width: 250px" placeholder="<?php echo __(LBL_EMAIL);?>" autocomplete="off">
                      </div>
                      
                      <div style="padding-bottom: 5px;">
                        <input type="text" id="firstname" name="firstname" value="" placeholder="Fornavn" style="padding-bottom: 3px; color: #515151; border: solid 1px #686868; width: 100px;">
                        <input type="text" id="lastname" name="lastname" value="" placeholder="Efternavn" style="padding-bottom: 3px; color: #515151; border: solid 1px #686868; width: 210px; margin-left: 8px;">
                      </div>
                      <div style="padding-bottom: 5px;">
                        <input type="text" id="address" name="paddress" value="" placeholder="Adresse" style="padding-bottom: 3px; color: #515151; border: solid 1px #686868; width: 320px;">
                      </div>
                      <div style="padding-bottom: 5px;">
                        <input type="text" id="postal_code" name="postal_code" value="" placeholder="Postnr." style="padding-bottom: 3px; color: #515151; border: solid 1px #686868;; width: 60px;">
                        <input type="text" id="city" name="city" value="" placeholder="By" style="padding-bottom: 3px; color: #515151; border: solid 1px #686868; width: 250px; margin-left: 8px;">
                      </div>
                      
  <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
  <tbody><tr>
  <td style=""><div style="padding-bottom: 5px;"><input type="text" id="phone_number" name="phone_number" value="" placeholder="Mobilnr." maxlength="8" style="padding-bottom: 3px; color: #515151; border: solid 1px #686868; width: 120px;"></div></td>
  <td style="text-align: right;">
    <div id="pay_error" style="display: none; color: #ffffff; background: #ff0000; border: solid 1px #ffffff; padding: 0px; font-size: 10px; text-align: center;">Husk at udfylde alle felter!</div>
    </td>
  </tr>
  </tbody></table>
  <table border="0" cellpadding="0" cellspacing="0" style="width: 100%; margin-top: 10px;">
  <tbody><tr>
  <td style=""><input type="button" name="close" id="btn_close" style="background-color: black; width: 98px; height: 24px; font-size: 8pt; cursor:pointer; color: #fff; border: none;" value="Fortryd">
    <input type="submit" name="submit" style="background-color: #069; width: 148px; height: 24px; font-size: 10pt; color: #fff; border: none; cursor: pointer" 
    value="<?php echo mb_convert_encoding("Fortsæt til betaling", "ISO_8859-1", "UTF-8");?>">
    </td>
  <td style="vertical-align: middle;"></td><td style="text-align: right;">
    </td>
  </tr>
  </tbody></table>
  </div></div></td>
  </tr>
  </tbody></table>
  </form></div></div></div>
</div>

  <script type="text/javascript">

    function computeTotal(qty) {
      var amount = parseFloat($('#pricepcs').val());
      var total = parseInt(qty.value) * amount;
      $("#amount").val(total);
    }
    
    function cancelThis() {
      $.fancybox.close();
    }
    
    function save() {
      $.fancybox.showActivity();
    }
    
    $("#btn_close").click(function(){
      $.fancybox.close();
    });
    
    $("#payment-form").bind('submit', function() {
      if($("#pay_from_email").val().length < 1 || $("#firstname").val().length < 1 || $("#lastname").val().length < 1 || $("#address").val().length < 1 || $("#postal_code").val().length < 1 || $("#city").val().length < 1 || $("#phone_number").val().length < 1 ) {
        $("#pay_error").show().delay(2000).fadeOut();
        return false;
      }
      
      $("#infobox").hide();
      $("#div_content").show();
      $.get("/payments/pay", { firstname: $("#firstname").val(), lastname: $("#lastname").val(), email: $("#pay_from_email").val(), address: $("#postal_code").val(), city: $("#city").val(), mobile: $("#phone_number").val() });
      return true;
      
    });

    $("#buy-button").fancybox({
        'autoDimensions'    : false,
        'height'            : 400,
        'width'             : 750,
    		'scrolling' : 'no',
    		'padding'   : 0,
    		'titleShow'	: false,
    		'onClosed'	: function() {
    		    window.location.reload(true);
    		}
    	});
    	
      $("#various7").fancybox({
      		onStart		:	function() {
      			return window.confirm('Continue?');
      		},
      		onCancel	:	function() {
      			alert('Canceled!');
      		},
      		onComplete	:	function() {
                  alert('Completed!');
      		},
      		onCleanup	:	function() {
                  return window.confirm('Close?');
      		},
      		onClosed	:	function() {
                  alert('Closed!');
      		}
      	});
    </script>
