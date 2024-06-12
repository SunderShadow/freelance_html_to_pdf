<h2><?= $registration['title']?></h2>
<table id="registration_data_table" class="colored_table">
    <tbody>
    <?php foreach ($registration['props'] as $key => $value): ?>
        <tr>
            <th><?= $key ?></th>
            <td><?= $value ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>