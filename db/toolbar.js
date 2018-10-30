function mouseover(el) {
  el.className = "raised";
}

function mouseout(el) {
  el.className = "button";
}

function mousedown(el) {
  el.className = "pressed";
}

function mouseup(el) {
  el.className = "raised";
}

function insert(txt,obj) {
//  var str = document.selection.createRange().text;
	if (window.getSelection)	{
		//var str = window.getSelection;
        var str = (obj.value).substring(obj.selectionStart,obj.selectionEnd);
	}
	else if (document.getSelection)	{
		var str = document.getSelection();
	}
	else if (document.selection)	{
		var str = document.selection.createRange().text;
	}
    obj.focus();
//  var sel = document.selection.createRange();

	if (window.getSelection)	{
		//var sel = window.getSelection();
        var pre_sel = (obj.value).substring(0,obj.selectionStart);
        //var sel = (obj.value).substring(obj.selectionStart,obj.selectionEnd);
        var post_sel = (obj.value).substring(obj.selectionEnd);
        obj.value = pre_sel  + txt + str + post_sel;
	}
	else if (document.getSelection)	{
		var sel = document.getSelection();
        sel.text =  txt + str;
	}
	else if (document.selection)	{
		var sel = document.selection.createRange();
        sel.text = txt + str;
	}
  return;
}

function create_list(v_start,v_end,obj) {
//  var str = document.selection.createRange().text;
	if (window.getSelection)	{
		//var str = window.getSelection;
        var str = (obj.value).substring(obj.selectionStart,obj.selectionEnd);
	}
	else if (document.getSelection)	{
		var str = document.getSelection();
	}
	else if (document.selection)	{
		var str = document.selection.createRange().text;
	}
    obj.focus();
//  var sel = document.selection.createRange();

	if (window.getSelection)	{
		//var sel = window.getSelection();
        var pre_sel = (obj.value).substring(0,obj.selectionStart);
        //var sel = (obj.value).substring(obj.selectionStart,obj.selectionEnd);
        var post_sel = (obj.value).substring(obj.selectionEnd);
        obj.value = pre_sel + v_start + "\n" + str + "\n" + v_end + "\n" + post_sel;
	}
	else if (document.getSelection)	{
		var sel = document.getSelection();
        sel.text = v_start + "\n" + str + "\n" + v_end + "\n";
	}
	else if (document.selection)	{
		var sel = document.selection.createRange();
        sel.text = v_start + "\n" + str + "\n" + v_end + "\n";
	}
  return;
}

function format_sel(v,obj) {
//  var str = document.selection.createRange().text;
	if (window.getSelection)	{
		//var str = window.getSelection;
        var str = (obj.value).substring(obj.selectionStart,obj.selectionEnd);
	}
	else if (document.getSelection)	{
		var str = document.getSelection();
	}
	else if (document.selection)	{
		var str = document.selection.createRange().text;
	}
    obj.focus();
//  var sel = document.selection.createRange();

	if (window.getSelection)	{
		//var sel = window.getSelection();
        var pre_sel = (obj.value).substring(0,obj.selectionStart);
        //var sel = (obj.value).substring(obj.selectionStart,obj.selectionEnd);
        var post_sel = (obj.value).substring(obj.selectionEnd);
        obj.value = pre_sel + "<" + v + ">" + str + "</" + v + ">" + post_sel;
	}
	else if (document.getSelection)	{
		var sel = document.getSelection();
        sel.text = "<" + v + ">" + str + "</" + v + ">";
	}
	else if (document.selection)	{
		var sel = document.selection.createRange();
        sel.text = "<" + v + ">" + str + "</" + v + ">";
	}
  return;
}

function insert_link(obj) {
//  var str = document.selection.createRange().text;
	if (window.getSelection)	{
		var str = (obj.value).substring(obj.selectionStart,obj.selectionEnd);
	}
	else if (document.getSelection)	{
		var str = document.getSelection();
	}
	else if (document.selection)	{
		var str = document.selection.createRange().text;
	}
  obj.focus();
  var my_link = prompt("Enter URL:","http://");
  var my_mailto = confirm("If this is and email link, click OK, otherwise, click cancel");
  if (my_mailto) { var mailto = "mailto:"; var target = "";}
  else  { var mailto = "";  var target = "target=\"_blank\"";}
  if (my_link != null) {
    //var sel = document.selection.createRange();
	//sel.text = "<a href=\"" + my_link + "\">" + str + "</a>";


    	if (window.getSelection)	{
    		//var sel = window.getSelection();
            var pre_sel = (obj.value).substring(0,obj.selectionStart);
            //var sel = (obj.value).substring(obj.selectionStart,obj.selectionEnd);
            var post_sel = (obj.value).substring(obj.selectionEnd);
            obj.value = pre_sel + "<a href=\"" + mailto + my_link + "\"" + " " + target + ">" + str + "</a>" + post_sel;
    	}
    	else if (document.getSelection)	{
    		var sel = document.getSelection();
            sel.text = "<a target=\"_blank\" href=\"" + mailto + my_link + "\"" + " " + target+ ">" + str + "</a>";
    	}
    	else if (document.selection)	{
    		var sel = document.selection.createRange();
            sel.text = "<a href=\"" + mailto + my_link + "\"" + " " + target+ ">" + str + "</a>";
    	}


  }
  return;
}
