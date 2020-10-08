<div class="col-10 margin-left-auto">
    <div class="row">
        <div class="col-12">
            <div class="card card--isHalf">
                    <div>
                        <table>
                            <thead>
                                <tr>
                                    <th>Matiere</th>
                                    <th>Note</th>
                                    <th>Nom</th>
                                    <th>Coeff</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($userInfo as $info) {?>
                                <tr>
                                    <td><?= $info["matiere"]?></td>
                                    <td><?= $info['note'] ?></td>
                                    <td><?= $info["name"]?></td>
                                    <td><?= $info["coefficient"]?></td>
                                    <td><?= $info["date"]?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>     
                    </div>
            </div>
        </div>
    </div>
</div>
