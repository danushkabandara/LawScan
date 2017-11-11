
<?php echo $this->Html->script('jquery-ui-1.10.3.custom.min'); ?>
<?php echo $this->Html->script('jquery-ui-1.10.3.custom'); ?>
<?php echo $this->Html->css('jquery-ui-1.10.3.custom.min'); ?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

<div class="workOrders index">
	<div class="row">
		<form method="POST" action="/lawscan/timesheets/result" id="clientSearchForm">
			<label>Client Name:</label>
			<div id="clients_wrapper">
				<input type="hidden" name="clients" value="" id="UserUser_">
				<select id="clientQuery" name="clients[]" data-placeholder="Chose One Or More Clients" multiple>
					<?php foreach($clients as $value=>$name):?>
						<option value="<?php echo $value;?>"><?php echo $name;?></option>
					<?php endforeach;?>
				</select>
				<div id="clients_button">
					<input type="button" id="select_all" name="select_all_clients" value="Select All">
				</div>
			</div>

			<label>Attorney Name:</label>
			<div id="clients_wrapper">
				<input type="hidden" name="users" value="" id="UserUser_">
				<select id="userQuery" name="users[]" data-placeholder="Chose One Or More Attorneys" multiple>
					<?php foreach($users as $value=>$name):?>
						<option value="<?php echo $value;?>"><?php echo $name;?></option>
					<?php endforeach;?>
				</select>
				<div id="clients_button">
					<input type="button" id="select_all" name="select_all_users" value="Select All">
				</div>
			</div>

			<label>Date:</label>
			<div class="dateForm">
				<label class="radio-inline">
					<input type="radio" name="dateOptions" id="dayOption" value="day" checked="checked"> Day
				</label>
				<label class="radio-inline">
					<input type="radio" name="dateOptions" id="weekOption" value="week"> Week
				</label>
				<label class="radio-inline">
					<input type="radio" name="dateOptions" id="monthOption" value="month"> Month
				</label>
				<label class="radio-inline">
					<input type="radio" name="dateOptions" id="yearOption" value="year"> Year
				</label>

				<div id="date_wrapper">
					<input id="date_text" class="input-sm" type="text" name="date">
					<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
				</div>
			</div>

			<input type="submit" value="Search" />
	   </form>
	</div>
</div>

<script>
	$(function(){
		$('#date_button').click(function(){

		});
		$.datepicker.setDefaults(
			$.extend($.datepicker.regional[''])
		);
		$('#date_text').datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'm/d/yy',
			maxDate: '+0d', // The max date that can be selected, i.e. + 1 month, 1 week, and 1 days from 'now'
		});
		$('#dayOption').focus(function() {
			$("#date_text").datepicker("destroy");
			$('#date_text').datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: 'm/d/yy',
				maxDate: '+0d', // The max date that can be selected, i.e. + 1 month, 1 week, and 1 days from 'now'
				beforeShow: function() {
					$(this).datepicker("widget").removeClass("datepickerTypeMonth datepickerTypeBill datepickerTypeQuart datepickerTypeYear ");
	        		$(this).datepicker("widget").addClass("datepickerTypeDay");
	    		},
			});
		});
		$('#monthOption').focus(function() {
			$("#date_text").datepicker("destroy");
			$('#date_text').datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: 'm/yy',
				maxDate: '+0d', // The max date that can be selected, i.e. + 1 month, 1 week, and 1 days from 'now'
				beforeShow: function() {
					$(this).datepicker("widget").removeClass("datepickerTypeDay datepickerTypeBill datepickerTypeQuart datepickerTypeYear ");
	        		$(this).datepicker("widget").addClass("datepickerTypeMonth");
	    		},
			});
		});
		$('#weekOption').focus(function() {
			$("#date_text").datepicker("destroy");
			$('#date_text').datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: 'm/d/yy',
				maxDate: '+0d', // The max date that can be selected, i.e. + 1 month, 1 week, and 1 days from 'now'
				onSelect: function(dateText, obj) {
	 				var date = $(this).datepicker('getDate');
	 				var dateFormat = 'mm/dd/yy';
	 				startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - (date.getDay()%7));
		     		$('#date_text').val($.datepicker.formatDate( dateFormat, startDate, obj.settings));
	    		},
				beforeShow: function() {
					$(this).datepicker("widget").removeClass("datepickerTypeMonth datepickerTypeDay datepickerTypeQuart datepickerTypeYear ");
	        		$(this).datepicker("widget").addClass("datepickerTypeBill");
	    		},
			});
		});
		$('#yearOption').focus(function() {
			$("#date_text").datepicker("destroy");
			$('#date_text').datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: 'yy',
				maxDate: '+0d', // The max date that can be selected, i.e. + 1 month, 1 week, and 1 days from 'now'
				beforeShow: function() {
					$(this).datepicker("widget").removeClass("datepickerTypeMonth datepickerTypeBill datepickerTypeQuart datepickerTypeDay ");
	        		$(this).datepicker("widget").addClass("datepickerTypeYear");
	    		},
			});
		});

		$(document.body).on('mousemove','.datepickerTypeBill .ui-datepicker-calendar tbody tr',function() {
    		$(this).find('td a').addClass('ui-state-hover');
    	});
    	$(document.body).on('mouseleave','.datepickerTypeBill .ui-datepicker-calendar tbody tr',function() {
    		$(this).find('td a').removeClass('ui-state-hover');
    	});
		$(document.body).on('mousemove','.datepickerTypeMonth .ui-datepicker-calendar tbody',function() {
    		$(this).find('tr td a').addClass('ui-state-hover');
    	});
    	$(document.body).on('mouseleave','.datepickerTypeMonth .ui-datepicker-calendar tbody',function() {
    		$(this).find('tr td a').removeClass('ui-state-hover');
    	});
    	$(document.body).on('mousemove','.datepickerTypeYear .ui-datepicker-calendar tbody',function() {
    		$(this).find('tr td a').addClass('ui-state-hover');
    	});
    	$(document.body).on('mouseleave','.datepickerTypeYear .ui-datepicker-calendar tbody',function() {
    		$(this).find('tr td a').removeClass('ui-state-hover');
    	});



		$('#clientQuery').chosen({
			no_results_text: "Client Not Found.",
			width: "60%"
		});
		$('input[name="select_all_clients"]').click(function() {
		    $('#clientQuery option').prop('selected', true);
		    $('#clientQuery').trigger('chosen:updated');
		});

		$('#userQuery').chosen({
			no_results_text: "Attorney Not Found.",
			width: "60%"
		});
		$('input[name="select_all_users"]').click(function() {
		    $('#userQuery option').prop('selected', true);
		    $('#userQuery').trigger('chosen:updated');
		});
		$('input[name="dateOptions"]').change(function() {
			$('#date_text').val("");
		})
	});
</script>