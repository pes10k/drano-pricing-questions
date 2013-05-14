<section>
    <div class="row">
        <div class="span12">
            <?=form_open()?>
                <fieldset>
                    <legend><h2>Editing Existing Rule</h2></legend>
                    <?=$rule_form?>

                    <div class="form-actions">
                        <button class="btn btn-primary" name="submit" id="submit" value="submit" type="submit">Save</button>
                        <button class="btn btn-warning" name="delete" id="delete" value="delete">Delete</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</section>
