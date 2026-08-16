<?php
$pageTitle = 'Contact';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/header.php';
?>

<div class="row">
  <div class="col-md-7 mb-4">
    <h2>Contact Us</h2>
    <p class="text-muted">Have a question about our systems or want a quote? Send us a message and we'll get back to you.</p>

    <div id="contact-alert"></div>

    <form id="contactForm" method="post" novalidate>
      <div class="mb-3">
        <label for="full_name" class="form-label">Full Name</label>
        <input type="text" class="form-control" id="full_name" name="full_name" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <div class="mb-3">
        <label for="subject" class="form-label">Subject</label>
        <input type="text" class="form-control" id="subject" name="subject" required>
      </div>
      <div class="mb-3">
        <label for="message" class="form-label">Message</label>
        <textarea class="form-control" id="message" name="message" rows="6" required></textarea>
      </div>
      <button type="submit" id="contactSubmit" class="btn btn-emerald">Send Message</button>
    </form>
  </div>

  <div class="col-md-5">
    <h4>Verdant Tech Farms HQ</h4>
    <p class="small text-muted mb-1">Email: <a href="mailto:info@verdanttech.farms">info@verdanttech.farms</a></p>
    <p class="small text-muted mb-1">Phone: <a href="tel:+1234567890">+1 (234) 567-890</a></p>
    <p class="small text-muted">Address: 123 Greenway Ave, Suite 200</p>

    <div class="mt-4">
      <h6>Office Hours</h6>
      <p class="small text-muted mb-0">Mon–Fri: 9:00 AM – 6:00 PM</p>
      <p class="small text-muted">Sat: By appointment</p>
    </div>
  </div>
</div>

<!-- jQuery AJAX to submit the form -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(function(){
    function showAlert(type, message) {
      var html = '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">'
        + message
        + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
        + '</div>';
      $('#contact-alert').html(html);
    }

    $('#contactForm').on('submit', function(e){
      e.preventDefault();

      var full_name = $.trim($('#full_name').val());
      var email = $.trim($('#email').val());
      var subject = $.trim($('#subject').val());
      var message = $.trim($('#message').val());

      if (!full_name || !email || !subject || !message) {
        showAlert('danger', 'Please fill out all fields.');
        return;
      }

      // Basic email format check
      var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(email)) {
        showAlert('danger', 'Please enter a valid email address.');
        return;
      }

      var $btn = $('#contactSubmit');
      $btn.prop('disabled', true).text('Sending...');

      $.ajax({
        url: 'process-contact.php',
        method: 'POST',
        dataType: 'json',
        data: { full_name: full_name, email: email, subject: subject, message: message },
        success: function(res) {
          if (res && res.success) {
            showAlert('success', res.message || 'Message sent. Thank you!');
            $('#contactForm')[0].reset();
          } else {
            showAlert('danger', res.message || 'An error occurred. Please try again later.');
          }
        },
        error: function() {
          showAlert('danger', 'Server error. Please try again later.');
        },
        complete: function() {
          $btn.prop('disabled', false).text('Send Message');
        }
      });
    });
  });
</script>

<?php
require_once __DIR__ . '/footer.php';
?>
