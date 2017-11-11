<div id = "header">
    <?php echo $this->Html->image('klokworklaw-web-logo.png', array('style' => 'margin:10px auto;display:block;','class' => 'img-responsive', 'alt' => 'Klokwork')); ?>
    <!--<h1>Law</h1>-->
</div>
    <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php echo $this->Html->charset(); ?>
        <title>
        <?php echo "KlokWork: Attorney Billing System"; ?>:
        <?php echo $title_for_layout; ?>
        </title>
    <?php
        echo $this->Html->meta('icon');
        echo $this->Html->script(array('https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'));
        echo $this->Html->css('bootstrap');
        echo $this->Html->css('cake.generic');

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
    ?>
    </head>
<!--body id="browserBackground" style="background: 'blue' ?>"-->

    <div class="container" id="container">

        <div id="content" class="login" style="background-color:#003d4c;overflow:none;">


        <?php echo $this->Session->flash(); ?>

        <?php echo $this->fetch('content'); ?>

        </div>

    </div>
    <?php echo $this->Html->script(array('bootstrap.min.js'));?>

<!--/body-->
</html>

    <script type="text/javascript">
    $(document).ready(function() {
        $('#flashMessage').animate({opacity: 1.0}, 5000).fadeOut("slow");
    $('#authMessage').animate({opacity: 1.0}, 5000).fadeOut("slow");
    });
    </script>
