<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h1><?= $title ?></h1>
            </div>
            <p class="lead"><?=$description?></p>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <table id="dataTable" class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="text-center text-middle">#</th>
                        <th class="hidden-xs text-center text-middle">Nombre</th>
                        <th class="text-center text-middle">Email</th>
                        <th class="hidden-xs text-center text-middle">Grupo</th>
                        <th class="hidden-xs text-center text-middle">Creado</th>
                        <th class="hidden-xs text-center text-middle">Activo</th>
                        <th class="text-center text-middle">
                            <button class="btn btn-xs btn-success" onclick="openModal('users/add', 'Nuevo Usuario')" data-toggle="tooltip" title="Nuevo" data-placement="top"><i class="fa fa-fw fa-plus"></i></button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user):?>
                    <?php if (!$user->is_active):?>
                    <tr class="warning">
                        <?php elseif ($user->is_locked):?>
                        <tr class="danger">
                            <?php else:?>
                            <tr>
                                <?php endif;?>
                                <th class="text-center text-middle">
                                    <?= $user->id ?>
                                </th>
                                <th class="text-middle hidden-xs">
                                    <?= $user->name1.' '.$user->lastname1 ?>
                                </th>
                                <th class=" text-middle">
                                    <?= $user->email ?>
                                </th>
                                <th class="hidden-xs text-center text-middle">
                                    <a href="<?= base_url('groups/show/'.$user->group_id)?>"><?= $user->group_name ?></a>
                                </th>
                                <th class="hidden-xs text-center text-middle">
                                    <?= strftime('%d/%m/%y', $user->created_at) ?>
                                </th>
                                <th class="hidden-xs text-center text-middle">
                                    <?= strftime('%d/%m/%y', $user->lastlogin_time) ?>
                                </th>
                                <th class="text-center text-middle">
                                    <div class="btn-group">
                                        <a href="<?=base_url('users/show/').$user->id?>" class="btn btn-xs btn-default show" data-toggle="tooltip" title="Ver Perfil" data-placement="top"><i class="fa fa-fw fa-user"></i></a>
                                        <button onclick="openModal('users/edit/<?=$user->id?>', 'Editar Usuario')" class="btn btn-xs btn-primary edit" data-toggle="tooltip" title="Editar" data-placement="top"><i class="fa fa-fw fa-pencil"></i></button>
                                        <?php if ($this->session->userdata('id') == $user->id):?>
                                        <button onclick="openModal('users/passwd_change/<?=$user->id?>', 'Cambiar Contraseña')" data-original-title="Cambiar contraseña" data-toggle="tooltip" type="button" class="btn btn-xs btn-info">
                                            <i class="fa fa-key fa-fw"></i>
                                        </button>
                                        <?php else:?>
                                        <button onclick="ajaxConfirm('users/passwd_reset/<?=$user->id?>', 'Enviaremos un correo electrónico al usuario con instrucciones para reestablecer su contraseña.')" data-original-title="Reestablecer contraseña" data-toggle="tooltip" type="button" class="btn btn-xs btn-info">
                                            <i class="fa fa-key fa-fw"></i>
                                        </button>
                                        <?php endif;?>
                                        <?php if (!$user->is_locked):?>
                                        <button onclick="ajaxGet('users/lock/<?=$user->id?>')" data-original-title="Bloquear" data-toggle="tooltip" type="button" class="btn btn-xs btn-warning"><i class="fa fa-lock fa-fw"></i></button>
                                        <?php else:?>
                                        <button onclick="ajaxGet('users/unlock/<?=$user->id?>')" data-original-title="Desbloquear" data-toggle="tooltip" type="button" class="btn btn-xs btn-warning"><i class="fa fa-unlock fa-fw"></i></button>
                                        <?php endif;?>
                                        <button onclick="ajaxConfirm('users/destroy/<?=$user->id?>')" data-original-title="Eliminar" data-toggle="tooltip" type="button" class="btn btn-xs btn-danger"><i class="fa fa-trash fa-fw"></i></button>
                                    </div>
                                </th>
                            </tr>
                        <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>