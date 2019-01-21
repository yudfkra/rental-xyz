<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <a href="<?php echo site_url('pesanan/add'); ?>" class="btn btn-primary">Tambah Pesanan</a>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Kode / No. Pol Mobil</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th class="text-center">Tanggal Input</th>
                            <th class="text-center">Tanggal Batas</th>
                            <th class="text-center">Tanggal Kembali</th>
                            <th class="text-center">Denda</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($list_pesanan)) { ?>
                            <?php $no = 0; $today = new DateTime('today'); foreach($list_pesanan as $pesanan) { ?>
                                <?php
                                    $class = '';
                                    $differ = $today->diff(new DateTime($pesanan->tanggal_batas_kembali));

                                    if (!in_array($pesanan->status, array(1, 3))) {
                                        // Jika melebihi batas
                                        if ($differ->invert) {
                                            $class = 'danger';
                                        // jika bertepatan dengan batas kembali
                                        } elseif ($differ->d == 0) {
                                            $class = 'success';
                                        }
                                    }
                                ?>
                                <tr class="<?php echo $class; ?>">
                                    <td><?php echo $no += 1; ?></td>
                                    <td><?php echo $pesanan->nama; ?></td>
                                    <td><?php echo $pesanan->alamat; ?></td>
                                    <td><?php echo "{$pesanan->kode_mobil} - {$pesanan->no_polisi}"; ?></td>
                                    <td><?php echo format_rp($pesanan->total_harga); ?></td>
                                    <td><?php echo $status[$pesanan->status]; ?></td>
                                    <td class="text-center"><?php echo $pesanan->tanggal_input; ?></td>
                                    <td class="text-center"><?php echo $pesanan->tanggal_batas_kembali; ?></td>
                                    <td class="text-center"><?php echo !empty($pesanan->tanggal_kembali) ? $pesanan->tanggal_kembali : '-'; ?></td>
                                    <td class="text-center"><?php echo format_rp($pesanan->denda); ?></td>
                                    <td class="text-center">
                                        <?php if ($pesanan->status == 2): ?>
                                            <?php if($differ->invert): ?>
                                                <a href="<?php echo site_url('pesanan/update/' . $pesanan->id . '/3'); ?>" class="btn btn-warning" onclick="return confirm('Anda yakin ingin merubah status menjadi terlambat ?');">Terlambat</a>
                                            <?php else: ?>
                                                <a href="<?php echo site_url('pesanan/update/' . $pesanan->id . '/1'); ?>" class="btn btn-success" onclick="return confirm('Anda yakin ingin merubah status menjadi selesai ?');">Selesai</a>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="11" class="text-center">Tidak ada data Pesanan</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>