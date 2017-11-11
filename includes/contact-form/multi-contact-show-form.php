<?php /**

 * @author William Sergio Minozzi

 * @copyright 2017

 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// $aurl = REALESTATEURL . 'includes/contact-form/processForm.php';

$aurl = "#";

$RealEstate_recipientEmail = trim(get_option('RealEstate_recipientEmail', ''));

if ( ! is_email($RealEstate_recipientEmail)) {

        $RealEstate_recipientEmail = '';

        update_option('RealEstate_recipientEmail', '');

    }

if (empty($RealEstate_recipientEmail))

    $RealEstate_recipientEmail = get_option('admin_email'); ?>

<?php Global $realestate_the_title; ?>  

<form id="RealEstate_contactForm" style="display: none;">

<!-- action="<?php echo $aurl; ?>" method="post"> -->

  <input type="hidden" name="RealEstate_recipientEmail" id="RealEstate_recipientEmail" value="<?php echo

$RealEstate_recipientEmail; ?>" />

  <input type="hidden" name="realestate_the_title" id="realestate_the_title" value="<?php echo $realestate_the_title; ?>" />

  <h2><?php 

  echo __('Request Information', 'realestate'); 

  ?>...</h2>

  <ul>

    <li>

      <label for="RealEstate_senderName" class="RealEstate_contact" ><?php echo __('Your Name',

'realestate'); ?>:&nbsp;</label>

      <input type="text" name="RealEstate_senderName" id="RealEstate_senderName" placeholder="<?php echo

__('Please type your name', 'realestate'); ?>" required="required" maxlength="40" />

    </li>

    <li>

      <label for="RealEstate_senderEmail" class="RealEstate_contact"><?php echo __('Your Email',

'realestate'); ?>:&nbsp;</label>

      <input type="email" name="RealEstate_senderEmail" id="RealEstate_senderEmail" placeholder="<?php echo

__('Please type your email', 'realestate'); ?>" required="required" maxlength="50" />

    </li>

    <li>

      <label for="RealEstate_sendermessage" class="RealEstate_contact" style="padding-top: .5em;"><?php echo

__('Your Message', 'realestate'); ?>:&nbsp;</label>

      <textarea name="RealEstate_sendermessage" id="RealEstate_sendermessage" placeholder="<?php echo

__('Please type your message', 'realestate'); ?>" required="required"  maxlength="10000"></textarea>

    </li>

  </ul>

<br />

  <div id="formButtons">

    <input type="submit" id="RealEstate_sendMessage" name="sendMessage" value="<?php echo

__('Send', 'realestate'); ?>" />

    <input type="button" id="RealEstate_cancel" name="cancel" value="<?php echo __('Cancel',

'realestate'); ?>" />

  </div>

<?php  wp_nonce_field('realestate_cform'); ?> 

</form>

<div id="RealEstate_sendingMessage" class="RealEstate_statusMessage" style="display: none; z-index:999;" ><p>Sending your message. Please wait...</p></div>

<div id="RealEstate_successMessage" class="RealEstate_statusMessage" style="display: none;  z-index:999;"><p>Thanks for your message! We'll get back to you shortly.</p></div>

<div id="RealEstate_failureMessage" class="RealEstate_statusMessage" style="display: none;  z-index:999;"><p>There was a problem sending your message. Please try again.</p></div>

<div id="RealEstate_email_error" class="RealEstate_statusMessage" style="display: none; z-index:999;"><p>Please enter one valid email address.</p></div>

<div id="RealEstate_incompleteMessage" class="RealEstate_statusMessage" style="display: none; z-index:999;"><p>Please complete all the fields in the form before sending.</p></div>

<div id="RealEstate_name_error" class="RealEstate_statusMessage" style="display: none; z-index:999;"><p>Name Error. Use only alpha.</p></div>

<div id="RealEstate_message_error" class="RealEstate_statusMessage" style="display: none; z-index:999;"><p>Message Error. Only Use only alpha and numbers.</p></div>



