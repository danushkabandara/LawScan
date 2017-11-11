

 <H2> Download Data </H2><br>


        <table >
            <tr style="color: #000;padding-top: 40px;"><td style="padding-left:40%;width: 100px;">Technician:
          
           <select id="technician" >
                   <?php foreach($technicians as $i => $el) {
                       if(is_int($i)) { // in case this array has mixed keys

                           echo  '<option value='.$i;
                           if($i==$techId)
                               echo ' selected=true ';
                           echo'>'.$el.'</option>';
                       }
                   }?>
            </select></div></td></tr>
            <tr style="color: #000;padding-top: 40px;"><td style="padding-left:40%;width: 100px;">Start Date:<div style="height: 40px;width:160px;"><input id="datepicker" style="margin-top:7px;margin-right: 7px;height: 20px;width: 130px;float:right;" type="text" value="<?php echo $chosenDate2; ?>"  /></div></td></tr>
            <tr style="color: #000;"><td style="padding-left:40%;">End Date:  <div style="height: 40px;width:160px;"><input id="datepicker1" style="margin-top:7px;margin-right: 7px;height: 20px;width: 130px;float:right;" type="text" value="<?php echo $chosenDate1; ?>"  /></div></tr>
            <tr style="float: left;"><td style="padding-left:600px;"><input type="submit" value="Download" name="Submit" id="submit_btn" onClick="download()"></td></tr>
            </table>


    <?php echo $this->Html->script('highcharts'); ?>
    <?php echo $this->Html->script('jquery-ui-1.10.3.custom.min'); ?>
    <?php echo $this->Html->css('jquery-ui-1.10.3.custom.min'); ?>
    <?php echo $this->Html->script('jquery.timePicker.min'); ?>


                <script>
                $(function(){
                    $.datepicker.setDefaults(
                        $.extend($.datepicker.regional[''])
                    );
                    $('#datepicker').datepicker({
                    changeMonth: true,
                    changeYear: true,
                    minDate: '-1y', // The min date that can be selected, i.e. 30 days from the 'now'
                    maxDate: '+0d', // The max date that can be selected, i.e. + 1 month, 1 week, and 1 days from 'now'

                    });
                });
                </script>
                <script>
                $(function(){
                    $.datepicker.setDefaults(
                        $.extend($.datepicker.regional[''])
                    );
                    $('#datepicker1').datepicker({
                    changeMonth: true,
                    changeYear: true,
                    minDate: '-1y', // The min date that can be selected, i.e. 30 days from the 'now'
                    maxDate: '+0d', // The max date that can be selected, i.e. + 1 month, 1 week, and 1 days from 'now'
                    });
                });
                    </script>
                    <script>
                function download() {
                    var date = $('#datepicker1').datepicker('getDate'),
                    day  = date.getDate(),
                    month = date.getMonth() + 1,
                    year =  date.getFullYear();
                    var date1 = $('#datepicker').datepicker('getDate'),
                    day1  = date1.getDate(),
                    month1 = date1.getMonth() + 1,
                    year1 =  date1.getFullYear();
                    window.location = "<?php echo Router::url(null, true); ?>?date1="+$("#datepicker").val()+"&date2="+$("#datepicker1").val()+"&building="+document.getElementById("technician").options[document.getElementById("technician").selectedIndex].value;

                    }
                </script>

