<section>
    <div class="row">
        <div class="span12">
            <?=form_open('')?>
                <fieldset>
                    <legend><h2>Add New Rule</h2></legend>
                    <?=$rule_form?>

                    <div class="form-actions">
                        <button class="btn btn-primary" name="submit" id="submit" value="submit" type="submit">Save</button>
                    </div>

                </fieldset>
            </form>
        </div>
    </div>
</section>

<section>
    <div class="row">
        <div class="span12">
            <h2>Existing Rules</h2>
            <?php if ($rules->count() === 0): ?>
                <div class="alert alert-info">There are no existing rules in the system.</div>
            <?php else: ?>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Domain</th>
                            <th>Severity</th>
                            <th>Factors</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $index = 0; foreach ($rules as $row): ?>
                            <tr>
                                <td><?=rule_favicon_tag($row)?></td>
                                <td><?=$row['name']?></td>
                                <td><?=$row['domain']?></td>
                                <td><?=$row['severity']?></td>
                                <td><?=implode(', ', $row['extra_factors'])?></td>
                                <td>
                                    <a class="btn" href="<?=rule_path($row)?>">Edit</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</section>
