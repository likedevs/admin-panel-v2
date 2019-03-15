<!--//BLOQUE COOKIES-->
<div id="barraaceptacion" style="display: block;">
    <div class="inner">
        <div class="row">
            <div class="col-md-9">
                Acest site utilizeaza cookie-uri. Prin continuarea navigarii sunteti de acord cu utilizarea cookie-urilor. Pentru mai multe informatii puteti consulta Politica de confidentialitate a datelor personale  <a href="http://politicadecookies.com" target="_blank" class="info">afla mai mult</a>
            </div>
            <div class="col-md-3">
                <a href="javascript:void(0);" class="ok" onclick="PonerCookie();"><b>Sunt deacord</b></a>
            </div>
        </div>
    </div>
</div>
 
<script>
if (getCookie('tiendaaviso') == 1) {
    document.getElementById("barraaceptacion").style.display="none";
}

function getCookie(c_name){
    var c_value = document.cookie;
    var c_start = c_value.indexOf(" " + c_name + "=");
    if (c_start == -1){
        c_start = c_value.indexOf(c_name + "=");
    }
    if (c_start == -1){
        c_value = null;
    }else{
        c_start = c_value.indexOf("=", c_start) + 1;
        var c_end = c_value.indexOf(";", c_start);
        if (c_end == -1){
            c_end = c_value.length;
        }
        c_value = unescape(c_value.substring(c_start,c_end));
    }
    return c_value;
}
 
function setCookie(c_name,value,exdays){
    var exdate=new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
    document.cookie=c_name + "=" + c_value;
}
 
if(getCookie('tiendaaviso')!="1"){
    document.getElementById("barraaceptacion").style.display="block";
}
function PonerCookie(){
    setCookie('tiendaaviso','1',365);
    document.getElementById("barraaceptacion").style.display="none";
}
</script>
<!--//FIN BLOQUE COOKIES-->
