jQuery(document).ready(function() {

    jQuery('#posts-filter').fadeTo(300, 1);

	var page_name = window.location.href;

	jQuery("form").each(function() {

		var form_name = jQuery(this).attr("id");

		if (form_name == 'posts-filter' && page_name.indexOf('post_type=realestatefields') > 0) {

			jQuery(".view").hide();

		}

	}); // end form loop

	if (!jQuery('#md_html_popupform').length) {

		jQuery('body').append('<div id="md_html_popupform" class="md-wrap-popupform" style="display: none;"></div>');

	}

	if (!jQuery('#md_html_buffer').length) {

		jQuery('body').append('<div id="md_html_buffer" class="md_info_popup" style="display: none;"></div>');

	}

/*

    jQuery('.tooltip').tooltipster({

       animation: 'fade',

       delay: 200

      // theme: 'tooltipster-punk',

      // theme: 'tooltipster-light',

      // trigger: 'click'

    });

*/

   jQuery("*").one("click", function(evt) {

       var realestate_page =  window.location.href;

       if ( ! realestate_page.includes("post_type=realestatefields"))

       { return; }

       var realestate_target = jQuery(this).attr('href');

       if(realestate_target === undefined)

       { 

           return; 

       }

       if (realestate_target.includes("&action=trash"))

       { 

           return; 

       }

       if (realestate_target.includes("&action=delete"))

       { 

           return; 

       }

       if (realestate_target.includes("&action=untrash"))

       { 

           return; 

       }         

       if (realestate_target.includes("post-new.php?post_type=realestatefields"))

       { var realestate_operation = "Add Field"; }

       else if (realestate_target.includes("post.php?post"))

        { var realestate_operation = "Edit Field"; } 

       else

       { 

        return; 

        }  

      //   alert(realestatenonceObj.security); 

		var billstring = evt.target.href;

		evt.preventDefault(billstring); 

        /* ----- GET -----------  */

		var postnum = $_GET('post', billstring);

        var realestatenonce = realestatenonceObj.realestatesecurity;

		jQuery.post({

			url: ajaxurl,

			data: {

				action: 'md_get_post_database',

				postid: postnum,

                realestatesecurity: realestatenonce,

			},

			success: function(fieldsdata) {

				var afieldsdata = jQuery.parseJSON(fieldsdata);

                /* -------- END GET ------------- */

				var realestateImagesUrl = realestate_images.realestateimagesUrl;

				var realestateUrl = realestate_plugin.realestateUrl;

				jQuery("#md_html_popupform").fadeIn();

				jQuery('#md_html_popupform').append("<div class='md_html_popupform' style='display:none'>");

				jQuery("#md_html_popupform").append("<div class='realestate-editform-title'>"+realestate_operation+"</div");

				jQuery('#md_html_popupform').append("<br />");

				jQuery("#md_html_popupform").append('<img id="realestate_form_help"  class="tooltip" src="' + realestateImagesUrl + 'help50.png" title="Put the cursor over each field to get  more info. For complete info, click the Help button at top right corner." style="float: right"/>');

				jQuery('#md_html_popupform').append("Name of Field:<br /><input type='text' class='tooltip' id='realestate_name' name='realestate_name' title ='This is the name of the Field. Use only letters and numbers. Use only one word. If you need use two, use underline between them. No blank spaces. For example: Fuel_Type. Do not create 2 fields with same name.' value='' /> <br /><br />");

				jQuery('#md_html_popupform').append("Label of Field: <br /> <input type='text' class='tooltip' id='realestate_label' name='realestate_label' title ='This is the name which will show up in your forms. only letters and numbers. It is optional. If you left empty we can use the same content of the name. You can use more then one word. For example: Fuel Type' value='' /> <br /><br />");

				jQuery('#md_html_popupform').append("Order: <br /> <input type='text' class='tooltip' id='realestate_order' name='realestate_order' title ='Order to show up at your form. Only numbers.' value='' style='max-width:50px;' />");

                jQuery('#md_html_popupform').append("<div id='md_form_2checkbox'></div>");

				jQuery('#md_form_2checkbox').append("<br /><br />");

				jQuery('#md_form_2checkbox').append("<input type='checkbox' class='tooltip' id='realestate_search' title ='Check if you want include this field in your Search Bar in your front page.' value='' />&nbsp;Show in Search Bar");

           		jQuery('#md_form_2checkbox').append("<br /><br />");

				jQuery('#md_form_2checkbox').append("<input type='checkbox' class='tooltip' id='realestate_search_widget' title ='Check if you want include this field in your Widget in your front page.' value=''  />&nbsp;Show in Search Widget");

                jQuery('#md_html_popupform').append("<br /><br />");

				jQuery('#md_html_popupform').append("Type of the Field:");

				jQuery('#md_html_popupform').append("<br />");

				jQuery('#md_html_popupform').append('<select id="realestate_typefield" class="form-control tooltip" title ="Choose one field type. Click to see the options available." ></select>');

				jQuery("#realestate_typefield").append(jQuery('<option>', {

					value: 'checkbox',

					text: 'Checkbox'

				}));

				jQuery("#realestate_typefield").append(jQuery('<option>', {

					value: 'dropdown',

					text: 'Drop Down'

				}));

				jQuery("#realestate_typefield").append(jQuery('<option>', {

					value: 'googlemap',

					text: 'Google Maps'

				}));

				jQuery("#realestate_typefield").append(jQuery('<option>', {

					value: 'rangeselect',

					text: 'Range Select'

				}));

                /*

				jQuery("#realestate_typefield").append(jQuery('<option>', {

					value: 'rangeslider',

					text: 'Range Slider'

				}));

                */

				jQuery("#realestate_typefield").append(jQuery('<option>', {

					value: 'text',

					text: 'Text'

				}));

				jQuery('#md_html_popupform').append("<br /><br />");

				jQuery('#md_html_popupform').append("<textarea class='tooltip' title ='Use only letters and numbers. No special carachters. One option each line.'  rows='4' cols='50' id='realestate-dropdown-options' name='realestate-dropdown-options' placeholder='type here the options. One by line'. style='display:none' ></textarea>");

				jQuery('#md_html_popupform').append('<p class="realestate_range" style="display:none">Range Min </p>');

				jQuery('#md_html_popupform').append('<input class="realestate_range tooltip" type="text" id="realestate_range_min" name="realestate_rangemin"  title="Only numbers. Min value. For example, for a car business, number of doors: 1" value="" style="display:none" />');

				jQuery('#md_html_popupform').append('<p class="realestate_range" style="display:none">Range Max </p>');

				jQuery('#md_html_popupform').append('<input class="realestate_range tooltip" type="text" id="realestate_range_max" name="realestate_rangemax"  title="Only numbers. Max value." value="" style="display:none" />');

				jQuery('#md_html_popupform').append('<p class="realestate_range" style="display:none">Range Step </p>');

				jQuery('#md_html_popupform').append('<input class="realestate_range tooltip" type="text" id="realestate_range_step" name="realestate_rangestep"  title="Only numbers. Step value. Maybe 1" value="" style="display:none" />');

				jQuery('#md_html_popupform').append('<p class="realestate_range_slider" style="display:none">Range Slider Min </p>');

				jQuery('#md_html_popupform').append('<input class="realestate_range_slider tooltip" type="text" id="realestate_slide_min" name="realestate_slidemin"  title="Only numbers. Min value. For example, for a car business, number of doors: 1" value="" style="display:none" />');

				jQuery('#md_html_popupform').append('<p class="realestate_range_slider" style="display:none">Range Slider Max </p>');

				jQuery('#md_html_popupform').append('<input class="realestate_range_slider tooltip" type="text" id="realestate_slide_max" name="realestate_slidemax"  title="Only numbers. Max value." value="" style="display:none" />');

				jQuery('#md_html_popupform').append('<p class="realestate_range_slider" style="display:none">Range Slider Step </p>');

				jQuery('#md_html_popupform').append('<input class="realestate_range_slider tooltip" type="text" id="realestate_slide_step" name="realestate_slidestep"  title="Only numbers. Step value. Maybe 1" value="" style="display:none" />');

				jQuery('#md_html_popupform').append("<br />");

				jQuery('#md_html_popupform').append("<br />");

				jQuery('#md_html_popupform').append("<br />");

				jQuery('#md_html_popupform').append("<br />");

				jQuery('#md_html_popupform').append('<a href="#" class="button button-primary realestate-close-submit">OK</a>');

				jQuery('#md_html_popupform').append('<img src="/wp-admin/images/wpspin_light-2x.gif" id="imagewaitfbl" style="display:none" />');

				jQuery('#md_html_popupform').append('<a href="#" class="button realestate-close-dialog">Cancel</a>'); /* end form */

                jQuery("#realestate_typefield").change(function() {

					$billmodal = jQuery('.md_html_popupform');

					jQuery('#realestate-dropdown-options').hide();

					jQuery('.realestate_range').hide();

					jQuery('.realestate_range_slider').hide();

                    jQuery('#md_form_2checkbox').show();

					if (this.value == 'dropdown') {

						jQuery('#realestate-dropdown-options').show();

						$billmodal.height(550);

					} else if (this.value == 'rangeselect') {

						jQuery('.realestate_range').show();

						$billmodal.height(500);

					} else if (this.value == 'rangeslider') {

						jQuery('.realestate_range_slider').show();

						$billmodal.height(500);

 					} else if (this.value == 'text' || this.value == 'googlemap' ) {    

                        jQuery('#md_form_2checkbox').hide();

						$billmodal.height(450);  

					} else {

						jQuery('#realestate-dropdown-options').hide();

						jQuery('#realestate_search_widget').show();

						jQuery('#realestate_search').show();

                        jQuery('#md_label_display_search').show();

                        jQuery('#md_label_display_search_widget').show();

                        jQuery('#md_form_2checkbox').show();

						$billmodal.height(375);

					}

					if (this.value == 'rangeselect') {

						jQuery('.realestate_range').show();

					} else {

						jQuery('.realestate_range').hide();

					}

				});

               //  alert(afieldsdata.length);

                if(realestate_operation == "Edit Field" && afieldsdata.length == 13)

                {

    				jQuery('#realestate_label').val(afieldsdata[0]); 

                    jQuery('#realestate_typefield').val(afieldsdata[1]);

                    jQuery('#realestate-dropdown-options').val(afieldsdata[2]); 

                    if(afieldsdata[3] == '1')

       			    	jQuery('#realestate_search').attr('checked',true);

                    if(afieldsdata[4] == '1')                

    			    	jQuery('#realestate_search_widget').attr('checked',true);

                    jQuery('#realestate_range_min').val(afieldsdata[5]); 

                    jQuery('#realestate_range_max').val(afieldsdata[6]); 

                    jQuery('#realestate_range_step').val(afieldsdata[7]); 				

                    jQuery('#realestate_slide_min').val(afieldsdata[8]); 

                    jQuery('#realestate_slide_max').val(afieldsdata[9]); 

                    jQuery('#realestate_slide_step').val(afieldsdata[10]);

                   	jQuery('#realestate_order').val(afieldsdata[11]);              

        			jQuery('#realestate_name').val(afieldsdata[12]);

                }    

                    // what select option ?

                    $billmodal = jQuery('.md_html_popupform');

                    jQuery('#md_form_2checkbox').show();

             		if (afieldsdata[1] == 'dropdown') {

						jQuery('#realestate-dropdown-options').show();

						$billmodal.height(550);

					} else if (afieldsdata[1] == 'rangeselect') {

						jQuery('.realestate_range').show();

						$billmodal.height(500);

					} else if (afieldsdata[1] == 'text' || afieldsdata[1] == 'googlemap' ) {

                        jQuery('#md_form_2checkbox').hide();

						$billmodal.height(450);

					} else if (afieldsdata[1] == 'rangeslider') {

						jQuery('.realestate_range_slider').show();

						$billmodal.height(500);

					}                

                    else {

						jQuery('#realestate-dropdown-options').hide();

						$billmodal.height(375);

					}

					if (afieldsdata[1] == 'rangeselect') {

						jQuery('.realestate_range').show();

					} else {

						jQuery('.realestate_range').hide();

					}   

                // Close

                jQuery(".realestate-close-dialog" ).click(function(evt) {

            		//	if (!jQuery(this).hasClass('disabled')) {

            				jQuery('#imagewaitfbl').hide();

            				$billmodal = jQuery('#md_html_popupform');

                            jQuery('#posts-filter').fadeTo(0, 0);

            				$billmodal.slideUp();

                            location.reload(); 

            		//	}

            	}); // end close

                // Save

                jQuery(".realestate-close-submit" ).click(function(evt) {

            		//	if (!jQuery(this).hasClass('disabled')) {

                    				postname = jQuery('#realestate_name').val();

                    				postlabel = jQuery('#realestate_label').val();

                                    posttypefield = jQuery('#realestate_typefield').val();

                                    postdropoptions = jQuery('#realestate-dropdown-options').val(); 

                                    if(jQuery('#realestate_search').is(":checked"))

                                       postsearchbar = 1;

                                    else

                                       postsearchbar = 0;

                                    if(jQuery('#realestate_search_widget').is(":checked"))

                                       postsearchwidget = 1;

                                    else

                                       postsearchwidget = 0;

                                    postrangemin = jQuery('#realestate_range_min').val();

                                    postrangemax = jQuery('#realestate_range_max').val();

                                    postrangestep = jQuery('#realestate_range_step').val();              	

                                    postslidemin = jQuery('#realestate_slide_min').val();

                                    postslidemax = jQuery('#realestate_slide_max').val();

                                    postslidestep = jQuery('#realestate_slide_step').val(); 

                                    postorder = jQuery('#realestate_order').val();              	

                            /*   *****  Begin Validator  ****  */

                            if(postname.length < 1)

                            {

                                 jQuery("#md_html_buffer").css("background-color","blue");

                                 md_show_info_popup("Blank Name.", "5000");

                                 return;

                            }

                           // alert(postname);

                            if( ! alphanumeric(postname))

                            {

                                 jQuery("#md_html_buffer").css("background-color","blue");

                                 md_show_info_popup("Invalid Name.", "5000");

                                 return;

                            }

                            if(postorder.length < 1)

                            {

                                 jQuery("#md_html_buffer").css("background-color","blue");

                                 md_show_info_popup("Blank Order.", "5000");

                                 return;

                            }                            

                            if( ! onlynumeric(postorder))

                            {

                                 jQuery("#md_html_buffer").css("background-color","blue");

                                 md_show_info_popup("Invalid Order Number.", "5000");

                                 return;

                            }

                            if( hasWhiteSpace(postname))

                            {

                                 jQuery("#md_html_buffer").css("background-color","blue");

                                 md_show_info_popup("Name: No Blank Spaces.", "5000");

                                 return;

                            }

                            if(postlabel.length < 1)

                            {

                                 jQuery("#md_html_buffer").css("background-color","blue");

                                 md_show_info_popup("Blank Label.", "5000");

                                 return;

                            }

                              if(! alphanumericext(postlabel))

                            {

                                 jQuery("#md_html_buffer").css("background-color","blue");

                                 md_show_info_popup("Invalid Label. Use only letters, numbers - and _", "5000");

                                 return;

                            }                          

                            if(posttypefield == "dropdown")

                            {

                                if(postdropoptions.length < 2)

                                {

                                     jQuery("#md_html_buffer").css("background-color","blue");

                                     md_show_info_popup("Blank Options.", "5000");

                                     return;

                                }

                                if( ! check_options(postdropoptions))

                                {

                                     jQuery("#md_html_buffer").css("background-color","blue");

                                     md_show_info_popup("Invalid Options. Use only Alpha Numeric.", "5000");

                                     return;

                                } 

                                                               

                            }

                            if(posttypefield == "rangeselect")

                            {

                                if(postrangemin.length < 1)

                                {

                                     jQuery("#md_html_buffer").css("background-color","blue");

                                     md_show_info_popup("Blank Range Min.", "5000");

                                     return;

                                }

                                if(postrangemax.length < 1)

                                {

                                     jQuery("#md_html_buffer").css("background-color","blue");

                                     md_show_info_popup("Blank Range Max.", "5000");

                                     return;

                                }

                                if(postrangestep.length < 1)

                                {

                                     jQuery("#md_html_buffer").css("background-color","blue");

                                     md_show_info_popup("Blank Range Steps.", "5000");

                                     return;

                                }       

                                //}

                                // alert(postrangemin);

                                if( ! onlynumeric(postrangemin))

                                {

                                     jQuery("#md_html_buffer").css("background-color","blue");

                                     md_show_info_popup("Invalid Range Min. Only Numeric.", "5000");

                                     return;

                                }

                                 if( ! onlynumeric(postrangemax))

                                {

                                     jQuery("#md_html_buffer").css("background-color","blue");

                                     md_show_info_popup("Invalid Range Max. Only Numeric.", "5000");

                                     return;

                                }                               

                                 if( ! onlynumeric(postrangestep))

                                {

                                     jQuery("#md_html_buffer").css("background-color","blue");

                                     md_show_info_popup("Invalid Range Step. Only Numeric.", "5000");

                                     return;

                                } 

                                if( parseInt(postrangemin) >= parseInt(postrangemax ))

                                {

                                     jQuery("#md_html_buffer").css("background-color","blue");

                                     md_show_info_popup("Range Min should be Minor than Range Max.", "5000");

                                     return;

                                }

                                if( parseInt(postrangestep) >= parseInt(postrangemax ))

                                {

                                     jQuery("#md_html_buffer").css("background-color","blue");

                                     md_show_info_popup("Range Step should be Minor than Range Max.", "5000");

                                     return;

                                }

                            }                            

                            /*         End Validator... */

                           	jQuery('#imagewaitfbl').show();

                            jQuery('.realestate-close-submit').attr('disabled', 'true');

                            jQuery('.realestate-close-dialog').attr('disabled', 'true');

                            if(postnum == null)

                               {postnum = '';}

                    		jQuery.post({

                    			url: ajaxurl,

                    			data: {

                    				action: 'md_save_post_database',

                                    realestatesecurity: realestatenonce,

                    				postid: postnum,

                                    field_name: postname,

                                    field_label: postlabel,

                                    field_typefield: posttypefield,

                                    field_drop_options: postdropoptions,

                                    field_searchbar: postsearchbar,

                                    field_searchwidget: postsearchwidget,

                                    field_rangemin: postrangemin,

                                    field_rangemax: postrangemax,

                                    field_rangestep: postrangestep,

                                    field_slidemin: postslidemin,

                                    field_slidemax: postslidemax,

                                    field_slidestep: postslidestep,

                                    field_order: postorder

                    			},                           

                                success: function(fieldsdata) { 

                    				$billmodal = jQuery('#md_html_popupform');

                                    jQuery('#posts-filter').fadeTo(0, 0);

                    				$billmodal.slideUp();

                                    location.reload();                                    

                                },

                            	error: function() {

                                 jQuery("#md_html_buffer").css("background-color","red");

                                 md_show_info_popup("Error to connect with Data Base (-5), Please, try again.", "5000");

                                 console.log(xhr.statusText);

                                 console.log(textStatus);

                                 console.log(error);                                 

                			    }

                         	}); // JQuery Post to Update                                             

            	}); // end save

            }, // Success Get Info 

			error: function(xhr, textStatus, error) {

                 jQuery("#md_html_buffer").css("background-color","red");

                 md_show_info_popup("Error to connect with Data Base (-5), Please, try again.", "5000");

                 console.log(xhr.statusText);

                 console.log(textStatus);

                 console.log(error); 

			}

		}); // JQuery Post to Get info         

	}); // end clicked edit ...  

});

function md_show_info_popup(text, delay) {

	jQuery("#md_html_buffer").text(text);

	jQuery("#md_html_buffer").fadeTo(400, 0.9);

	window.setTimeout(function() {

		jQuery("#md_html_buffer").fadeOut(400);

	}, delay);

}

function $_GET(param, url) {

	var vars = {};

	url.replace(location.hash, '').replace(/[?&]+([^=&]+)=?([^&]*)?/gi, // regexp

	function(m, key, value) { // callback

		vars[key] = value !== undefined ? value : '';

	});

	if (param) {

		return vars[param] ? vars[param] : null;

	}

	return vars;

}

function alphanumeric(inputtext)

{

     if( /[^a-zA-Z0-9]/.test( inputtext ) ) {

       // this.value = this.value.replace(/[^a-zA-Z0-9 ]/g, '');

       return false;

     }

    return true;

}  

function alphanumericext(inputtxt)

{

     if( /[^a-zA-Z0-9-_ ]/.test( inputtxt ) ) {

       return false;

     }

    return true;

}

function onlynumeric(inputtxt)

{

  return !/\D/.test(inputtxt);

}

function hasWhiteSpace(inputtxt) {

  return inputtxt.indexOf(' ') >= 0;

}



function check_options(txt){

var txtArray=txt.split('\n');

    for(var i=0;i<txtArray.length;i++){

      /\s$/.test(txtArray[i])?txtArray[i]=txtArray[i].replace(/\s$/,''):null;

     if( ! alphanumericext(txtArray[i]))

      {

        return false;

        

      }

    }

    return true;

}