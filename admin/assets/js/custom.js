// JavaScript Document
/*$(function(){
	alert('boooo');
	$('#all_keywords_table').dataTable({
		"sScrollX": "100%",
		"sScrollXInner": "110%",
		"bScrollCollapse": true
	});
});*/

$(function() {
$(".datepicker_jui").datepicker();

//for selecting menu
        /*var url = window.location.pathname, 
        urlRegExp = new RegExp(url == '/' ? window.location.origin + '/?$' : url.replace(/\/$/,'')); // create regexp to match current url pathname and remove trailing slash if present as it could collide with the link in navigation in case trailing slash wasn't present there
        // now grab every link from the navigation
        $('ul.menu a').each(function(){
            // and test its normalized href against the url pathname regexp
            if(urlRegExp.test(this.href.replace(/\/$/,''))){
                $(this).parent('li').addClass('active');
            }
        });*/
/*var activeurl = window.location;
$('a[href="'+activeurl+'"]').parent('li').addClass('active');*/
//END for selecting menu
});

function delete_sure()
{
	var msg=confirm("Are you sure you want to delete this permanently from database?");
	if(msg==true)
	{
		return true;
	}
	else
	{
		return false;
	}
	return false;
}

function inactive_before_delete_msg()
{
	alert("You can't delete this while it is active. Please Inactive this if you want to Delete.");
	return false;
}

////////////
/*function mba_result_modal_data(id)
{
    $('#row_id').val(id);
    
    var item= $("tr.main_row_"+id+" td:nth-child(1)");
    $('#student_id_modal').html('Student ID: '+item.text());
    
    var item= $("tr.main_row_"+id+" td:nth-child(5)");
    $('#class_performance').val(item.text());
    var item= $("tr.main_row_"+id+" td:nth-child(6)");
    $('#assignment').val(item.text());
    var item= $("tr.main_row_"+id+" td:nth-child(7)");
    $('#presentation').val(item.text());
    
    var item= $("tr.main_row_"+id+" td:nth-child(8)");
    $('#mid_1').val(item.text());
    var item= $("tr.main_row_"+id+" td:nth-child(9)");
    $('#mid_2').val(item.text());
    
    var item= $("tr.main_row_"+id+" td:nth-child(10)");
    $('#final').val(item.text());
}*/
function category_keyword_modal_data(id)
{
    $('#row_id').val(id);
    
    var item= $("tr.main_row_"+id+" td:nth-child(2)");
    $('#keyword_category_name_modal').val(item.text());
    var item= $("tr.main_row_"+id+" td:nth-child(3)");
    $('#status_modal').val(item.text());
    $("#status_modal").select2("val", item.text());
}
function keyword_modal_data(id)
{
    $('#row_id').val(id);
    
    var item= $("tr.main_row_"+id+" td:nth-child(4)");
    $('#entity_name').val(item.text());

    var item= $("tr.main_row_"+id+" td:nth-child(5)");
    $('#picture').val(item.text());

    var item= $("tr.main_row_"+id+" td:nth-child(6)");
    $('#street_name').val(item.text());

    var item= $("tr.main_row_"+id+" td:nth-child(7)");
    $('#zipcode').val(item.text());

    var item= $("tr.main_row_"+id+" td:nth-child(8)");
    $('#area').val(item.text());

    var item= $("tr.main_row_"+id+" td:nth-child(9)");
    $('#phone_number').val(item.text());

    var item= $("tr.main_row_"+id+" td:nth-child(10)");
    $('#phone_number2').val(item.text());

    var item= $("tr.main_row_"+id+" td:nth-child(19)");
    $('#sort_order').val(item.text());

    var item= $("tr.main_row_"+id+" td:nth-child(11)");
    $('#latitude').val(item.text());

    var item= $("tr.main_row_"+id+" td:nth-child(12)");
    $('#longitude').val(item.text());

    var item= $("tr.main_row_"+id+" td:nth-child(13)");
    $('#web').val(item.text());

    var item= $("tr.main_row_"+id+" td:nth-child(14)");
    $('#email').val(item.text());

    var item= $("tr.main_row_"+id+" td:nth-child(16)");
    $('#announcements').val(item.text());

    var item= $("tr.main_row_"+id+" td:nth-child(3)");
    $('#cat_id').text(item.text());
    //$("#cat_id").select2("text", item.text());

    $("#cat_id").select2("data", {text: item.text()});

    var item= $("tr.main_row_"+id+" td:nth-child(15)");
    $('#promoted_posts').val(item.text());
    $("#promoted_posts").select2("val", item.text());
}
//////////////
var sPath = window.location.pathname;

$(function(){
    
	// add multiple select / deselect functionality
    $('.check_all').click(function () {
		  if($('.check_all').is(':checked')) {
				$('.cb_element').prop('checked', true);
			} else{
				$('.cb_element').prop('checked', false);
			} 
    });
 
    // if all checkbox are selected, check the selectall checkbox
    // and viceversa
    $('.cb_element').click(function(){
         if($('.cb_element').length == $(".cb_element:checked").length) {
			$('.check_all').prop('checked', true);
        } else {
			$('.check_all').prop('checked', false);
        }
    });
	
	$('.delete_multiple_message').click(function(event) {
		event.preventDefault();
		var selectedItems = new Array();
		//$("input[@name='delete_id[]']:checked").each(function() {selectedItems.push($(this).val());});
		$(".cb_element:checked").each(function() {selectedItems.push($(this).val());});
		if (selectedItems.length == 0)
		{
   		   alert("Please select item(s) to delete.");
		   return false;
		}
		else
		{
			var selectedval="";
			for(var i=0; i<selectedItems .length; i++)
			{
				var selected=selectedItems[i]+"~";
				selectedval=selectedval+selected;
				//alert(selectedval);
			}
			//alert('hello'+selectedval);
			var r=confirm("Are you sure you want to Delete these?");
			
			if (r==true)
	 		 {
				var val = $(this).attr('href');
				var val=val+selectedval;
				//alert(val);
				$.post(val,{},
				function() {
					reload_win();
				});
			}
		}
		
		event.preventDefault();
	});
	   	
});

function reload_win()
{
	window.location.href=sPath;
}