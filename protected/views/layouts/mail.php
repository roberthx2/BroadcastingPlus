<html>
    <head>
        <meta content="text/html; charset=UTF-8" http-equiv="content-type">
    </head>
    <table cellspacing="0" cellpadding="10" style="color:#666;font:13px Arial;line-height:1.4em;width:100%;">
        <tbody>
            <tr>
                <!--<td style="padding:15px 20px;text-align:right;padding-top:5px;border-top:solid 1px #dfdfdf">
                    <a href="http://www.clubdefanaticosmidiario.com/"><img alt="" src="../../img/bannerMovil.jpg" /></a>
                </td>-->
            </tr>
            
            <tr>
                <td style="color:#4D90FE;font-size:22px;border-bottom: 2px solid #4D90FE;">
                    <?php //echo CHtml::encode(Yii::app()->name); ?>
                </td>
            </tr>
            <tr>
                <td style="color:#777;font-size:16px;padding-top:5px;">
                    <?php if (isset($data['description'])) echo $data['description']; ?>
                </td>
            </tr>
            <tr>
                <td style="font-family: News701 BT; font-size:20px;padding-top:5px">
                    <?php echo $content ?>
                </td>
            </tr>
            
        </tbody>
    </table>
    <div id="footer_new">
        <br>
       <img src="../../img/logo_imc_red.png" width="150px" height="40px">
       <br><strong>Copyright &copy; <?php echo date('Y'); ?> by <a href="https://broadcasting.insignia.web.ve">Insignia Mobile Communications C.A.</strong></a>.<br/>
       <strong>All Rights Reserved.</strong><br/>
    </div><!-- footer -->
</body>
</html>

<style type="text/css">
    #footer_new
    {
        position:fixed;
        right:0;
        left:0;
        z-index:1030;
        bottom:0;
        margin: 0px 0px;
        font-size: 0.8em;
        text-align: center;
        border-top: 2px solid #4D90FE;
        background: white;
    }
</style>