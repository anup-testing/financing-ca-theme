<?php
/**
 * Title: CTA and partner signup form
 * Slug: financing-ca/signup
 * Categories: financing-ca
 * Inserter: yes
 */
?>
<!-- wp:group {"tagName":"section","className":"cta","anchor":"signup"} -->
<section id="signup" class="wp-block-group cta">
<!-- wp:group {"className":"wrap cta-in"} -->
<div class="wp-block-group wrap cta-in">
<!-- wp:group {"className":"reveal"} -->
<div class="wp-block-group reveal">
<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">Ready to quote in monthly payments?</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Tell us about your business and a Financing.ca specialist will walk you through the program, the rate card and the onboarding timeline.</p>
<!-- /wp:paragraph -->
<!-- wp:list {"className":"cta-ticks"} -->
<ul class="wp-block-list cta-ticks"><!-- wp:list-item -->
<li>No setup cost, no monthly minimum</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>Onboarding in under a week</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>Dedicated partner success manager</li>
<!-- /wp:list-item -->
</ul>
<!-- /wp:list -->
</div>
<!-- /wp:group -->
<!-- wp:html -->
<form class="form reveal" id="leadform" novalidate>
  <h3>Become a partner</h3>
  <div class="row">
    <label>Business name<input name="business" required placeholder="Northside HVAC Ltd." /></label>
  </div>
  <div class="row two-col">
    <label>Your name<input name="name" required placeholder="Jordan Patel" /></label>
    <label>Phone<input name="phone" type="tel" required placeholder="(416) 555-0134" /></label>
  </div>
  <div class="row">
    <label>Work email<input name="email" type="email" required placeholder="jordan@northsidehvac.ca" /></label>
  </div>
  <div class="row two-col">
    <label>Province
      <select name="province"><option>Ontario</option><option>British Columbia</option><option>Alberta</option><option>Quebec</option><option>Manitoba</option><option>Saskatchewan</option><option>Nova Scotia</option><option>New Brunswick</option><option>Newfoundland and Labrador</option><option>Prince Edward Island</option></select>
    </label>
    <label>Industry
      <select name="industry"><option>HVAC &amp; Heating</option><option>Windows &amp; Doors</option><option>Roofing &amp; Exteriors</option><option>Pools &amp; Spas</option><option>Water Treatment</option><option>Home Renovation</option><option>Vehicle &amp; Powersports</option><option>Retail &amp; Fitness</option></select>
    </label>
  </div>
  <div class="hp" aria-hidden="true"><label>Leave this empty<input name="website" tabindex="-1" autocomplete="off" /></label></div>
  <button class="btn primary full" type="submit">Request a call</button>
  <p class="form-note" id="formnote">We'll only use your details to contact you about the partner program.</p>
</form>
<!-- /wp:html -->
</div>
<!-- /wp:group -->
</section>
<!-- /wp:group -->
