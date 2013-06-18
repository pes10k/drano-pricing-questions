<label for="name">Name</label>
<input type="text" name="name" id="name" value="<?=get_val($rule, 'name')?>">
<span class="help-block">A user visible name for the rule, like <em>Amazon Order Record</em></span>

<label for="domain">Domain</label>
<input type="text" name="domain" id="domain" placeholder="http://example.org" value="<?=get_val($rule, 'domain')?>">
<span class="help-block">The full root domain to be associated with this rule.</span>

<label for="severity">Severity</label>
<?=form_dropdown('severity', array_to_assoc(array('Password given', 'Email only', 'Email plus')),
    get_val($rule, 'severity'), 'id="severity"')?>
<span class="help-block">The level of access to a remote account that rule represents.  <strong>Password given</strong> indicates that the password for the remote account is already transmited in the clear and exists in the email account. <strong>Email only</strong> means that access to the email account is enough to gain access to the remote account.  <strong>Email plus</strong> denotes that some additional information or factors are needed to gain access to the remote account.</span>

<label for="extra_factors">Extra Factors</label>
<input type="text" name="extra_factors" id="extra_factors" placeholder="Additional Factors" autocomplete="off" data-items="6" class="tagManager" value="<?=implode(',', array_map('trim', get_val($rule, 'extra_factors')))?>">
<span class="help-block">Record any additional security factors this site uses to control access to this account (such as <em>2 factor authentication</em>)</span>

<label for="more_email_info">Included Info in Emails</label>
<input type="text" name="more_email_info" id="more_email_info" placeholder="Included Info" autocomplete="off" data-items="6" class="tagManager" value="<?=implode(',', array_map('trim', get_val($rule, 'more_email_info')))?>">
<span class="help-block">What information, other than account access, is included in emails sent from this source? For example, <em>social security number</em>, <em>birthday</em> or <em>address</em>.</span>


<label for="price">Price</label>
<?php if ($prices = get_val($rule, 'prices')): ?>
    $<input type="text" name="price" id="price" placeholder="X.XX" value="<?=number_format($prices[count($prices) - 1]['price'], 2)?>">
<?php else: ?>
    $<input type="text" name="price" id="price" placeholder="X.XX" value="">
<?php endif; ?>
<span class="help-block">The approximate price that this information could go for on the black market.</span>

<label for="broad_rules">Broad Rules</label>
<textarea class="input-block-level" name="broad_rules" id="broad_rules" rows="3"><?=implode("\n", get_val($rule, 'broad_rules') ?: array())?></textarea>
<span class="help-block">A set of rules to be used against the Gmail IMAP search. Multiple rule should be entered one per line. See Google's documentation of <a href="http://support.google.com/mail/answer/7190?hl=en">advanced Gmail search operators</a> for options. These rules will be <strong>OR'ed</strong> together.</span>

<label for="broad_rules_negation">Broad Negation Rules</label>
<textarea class="input-block-level" name="broad_rules_negation" id="broad_rules_negation" rows="3"><?=implode("\n", get_val($rule, 'broad_rules_negation') ?: array())?></textarea>
<span class="help-block">A set of rules, also applied at the IMAP level, that will negate returned results.  Don't bother adding the "-" to the beginning of each rule.</span>


<label for="narrow_rule">Narrow Rule</label>
<input type="text" name="narrow_rule" id="narrow_rule" value="<?=get_val($rule, 'narrow_rule')?>">
<span class="help-block">The narrow, filtering rule that should be searched for against the body of fetched emails.</span>

<label class="checkbox">
    <input type="checkbox" name="narrow_rule_is_regex" id="narrow_rule_is_regex" value="1" <?=(get_val($rule, 'narrow_rule_is_regex') ? 'checked="checked"' : '')?>> Narrow rule is regular expression
</label>

<script>
    drano.m.extra_factors = <?=json_encode($extra_factors)?>;
    drano.m.more_email_info = <?=json_encode($more_email_info)?>;
</script>
