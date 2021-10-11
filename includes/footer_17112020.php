		<!--footer-->
		<div class="footer">
		   <p>&nbsp;&nbsp;&nbsp;&nbsp;&copy; <?=date('Y')?> <?=solutionname?> - <?=solutionfull?>. All Rights Reserved | Developed by <a href="http://rebserp.com/" target="_blank"><?=provider?></a> | Customised for <?=companyname?> </p>
		</div>
        <!--//footer-->
	</div>
	<!-- Classie -->
		<script src="<?=base_url()?>media/js/classie.js"></script>
		<script>
			var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
				showLeftPush = document.getElementById( 'showLeftPush' ),
				body = document.body;
				
			showLeftPush.onclick = function() {
				classie.toggle( this, 'active' );
				classie.toggle( body, 'cbp-spmenu-push-toright' );
				classie.toggle( menuLeft, 'cbp-spmenu-open' );
				disableOther( 'showLeftPush' );
			};
			

			function disableOther( button ) {
				if( button !== 'showLeftPush' ) {
					classie.toggle( showLeftPush, 'disabled' );
				}
			}
		</script>
        <link href="<?=base_url()?>media/css/autoscroll.css" rel="stylesheet"> 

	<!--scrolling js-->
	<script src="<?=base_url()?>media/js/jquery.nicescroll.js"></script>
	<script src="<?=base_url()?>media/js/scripts.js"></script>
	<!--//scrolling js-->
	<!-- Bootstrap Core JavaScript -->
   <script src="<?=base_url()?>media/js/bootstrap.js"> </script>
   <script src="<?=base_url()?>media/js/validator.min.js"></script>
   <script src="<?=base_url()?>media/js/chosen-readonly.min.js"></script>
   <script>
	// request permission on page load
	document.addEventListener('DOMContentLoaded', function () {
	  if (!Notification) {
		alert('Desktop notifications not available in your browser. Try latest version of Chrome or Firefox.'); 
		return;
	  }
	
	  if (Notification.permission !== "granted")
		Notification.requestPermission();
	});
	
	
	func();
	function func(){
		$.ajax({
			cache: false,
			type: 'POST',
			url: '<?php echo base_url().'common/get_user_notification_alert';?>',
			data: '',
			success: function(data) {
				if (data) {
					var arr = JSON.parse(data);
					$.each($(arr),function(key,value){
						if (Notification.permission !== "granted")
							Notification.requestPermission();
						else {
							var notification = new Notification('<?=solutionname?> - <?=solutionfull?>', {
							  //icon: 'https://www.efserp.com/images/favicon.png', //this is the logo for EFS ERP
							  icon: 'http://www.rebserp.com/images/favicon.png', //this is the logo for REBS ERP
							  body: value[0]+" Pending "+value[1],
							  tag: value[0]+value[1]
							});
						
							notification.onclick = function () {
							  window.open("<?=base_url()?>"+value[2]);      
							};
	
						}
					});
				} 
			}
		});
	
		// Set a timer to call
		// this code again.
		setTimeout( func, 60000); //time in milliseconds
	}
	
	</script>
</body>
</html>