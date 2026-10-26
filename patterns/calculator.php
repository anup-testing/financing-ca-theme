<?php
/**
 * Title: Payment calculator
 * Slug: financing-ca/calculator
 * Categories: financing-ca
 * Inserter: yes
 */
?>
<!-- wp:group {"tagName":"section","className":"section calc-sec","anchor":"calculator"} -->
<section id="calculator" class="wp-block-group section calc-sec">
<!-- wp:group {"className":"wrap two"} -->
<div class="wp-block-group wrap two">
<!-- wp:group {"className":"reveal"} -->
<div class="wp-block-group reveal">
<!-- wp:paragraph {"className":"kicker"} -->
<p class="kicker">Reframe the price</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":2,"className":"h2"} -->
<h2 class="wp-block-heading h2">Your price tag isn't <span class="strike">$12,000</span>. It's <span class="hl">$129 a month.</span></h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"body"} -->
<p class="body">A monthly number keeps the conversation going. Your sales team can quote a payment in seconds — on a phone, a tablet, or right inside your quoting software — and watch close rates climb.</p>
<!-- /wp:paragraph -->
<!-- wp:list {"className":"ticks"} -->
<ul class="wp-block-list ticks"><!-- wp:list-item -->
<li>Quote a payment before you quote a price</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>Upsell the better unit without resetting the budget</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>Fewer "let me think about it" conversations</li>
<!-- /wp:list-item -->
</ul>
<!-- /wp:list -->
<!-- wp:html -->
<div class="mini-stats">
  <div><strong>+32%</strong><span>average close rate lift*</span></div>
  <div><strong>+18%</strong><span>average ticket size*</span></div>
</div>
<!-- /wp:html -->
<!-- wp:paragraph {"className":"fineprint"} -->
<p class="fineprint">*Illustrative figures for this concept build.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:html -->
<div class="calc reveal" role="group" aria-label="Monthly payment calculator">
  <div class="calc-head">
    <h3>Payment calculator</h3>
    <span class="pill">Live demo</span>
  </div>
  <label class="field">
    <span class="fl">Project amount <b id="amtOut">$12,000</b></span>
    <input id="amt" type="range" min="1000" max="100000" step="100" value="12000" />
    <span class="range-ends"><i>$1,000</i><i>$100,000</i></span>
  </label>
  <div class="field">
    <span class="fl">Term</span>
    <div class="seg" id="term" role="radiogroup" aria-label="Term">
      <button role="radio" aria-checked="false" data-v="60">60 mo</button>
      <button role="radio" aria-checked="false" data-v="120">120 mo</button>
      <button role="radio" aria-checked="true" data-v="180" class="on">180 mo</button>
    </div>
  </div>
  <div class="field">
    <span class="fl">Promotion</span>
    <div class="seg" id="promo" role="radiogroup" aria-label="Promotion">
      <button role="radio" aria-checked="true" data-v="9.99" class="on">Standard 9.99%</button>
      <button role="radio" aria-checked="false" data-v="6.99">Buy-down 6.99%</button>
      <button role="radio" aria-checked="false" data-v="0">0% for 24 mo</button>
    </div>
  </div>
  <div class="calc-out">
    <div>
      <span>Monthly payment</span>
      <strong id="pay">$129<small>/mo</small></strong>
    </div>
    <div class="calc-side">
      <span>Est. cost of borrowing</span>
      <b id="cob">$3,180</b>
    </div>
  </div>
  <p class="calc-note">Illustrative only. Rates, terms and approvals are subject to credit review and final program terms.</p>
</div>
<!-- /wp:html -->
</div>
<!-- /wp:group -->
</section>
<!-- /wp:group -->
