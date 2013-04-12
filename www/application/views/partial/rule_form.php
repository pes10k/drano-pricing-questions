<label for="name">Name</label>
<input type="text" name="name" id="name" value="<?=get_val($rule, 'name')?>">
<span class="help-block">A user visible name for the rule, like <em>Amazon Order Record</em></span>

<label for="domain">Domain</label>
<input type="text" name="domain" id="domain" placeholder="http://example.org" value="<?=get_val($rule, 'domain')?>">
<span class="help-block">The full root domain to be associated with this rule.</span>

<label for="broad_rules">Broad Rules</label>
<textarea name="broad_rules" id="broad_rules" rows="3"></textarea>
<span class="help-block">A set of rules to be used against the Gmail IMAP search. Multiple rule should be entered one per line. See Google's documentation of <a href="http://support.google.com/mail/answer/7190?hl=en">advanced Gmail search operators</a> for options. These rules will be <strong>OR'ed</strong> together.</span>

<label for="narrow_rule">Narrow Rule</label>
<input type="text" name="narrow_rule" id="narrow_rule" value="<?=get_val($rule, 'narrow_rule')?>">
<span class="help-block">The narrow, filtering rule that should be searched for against the body of fetched emails.</span>

<label class="checkbox">
    <input type="checkbox" name="narrow_rule_is_regex" id="narrow_rule_is_regex" value="1" checked="<?=(get_val($rule, 'narrow_rule_is_regex') == '1') ? 'checked' : ''?>"> Narrow rule is regular expression
</label>
