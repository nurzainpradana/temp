
<form>
Show form? 
<input type="radio" id="showform" value="yes" name="showform" onchange="showhideForm(this.value);"/>Yes
<input type="radio" id="showform" value="no" name="showform" onchange="showhideForm(this.value);"/>No
</form>

<script type="text/javascript">
function showhideForm(showform) {
    if (showform == "yes") {
        document.getElementById("div1").style.display = 'block';
        document.getElementById("div2").style.display = 'none';
    } 
    if (showform == "no") {
        document.getElementById("div2").style.display = 'block';
        document.getElementById("div1").style.display = 'none';
    }
}
</script>

<div id="div1" style="display:none">
[formidable id=18]
</div>
<div id="div2" style="display:none">
You are not qualified to see this form.
</div>
