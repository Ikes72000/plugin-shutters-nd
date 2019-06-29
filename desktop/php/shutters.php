<?php
/*
 * This file is part of the NextDom software (https://github.com/NextDom or http://nextdom.github.io).
 * Copyright (c) 2018 NextDom.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, version 2.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

if (!isConnect('admin')) {
    throw new \Exception('{{401 - Accès non autorisé}}');
}
$plugin = plugin::byId('shutters');
sendVarToJS('eqType', $plugin->getId());
$eqLogics = eqLogic::byType($plugin->getId());
?>

    <section class="content-header" style="top: 50px; padding-right: 65px;">
        <div class="action-bar scroll-shadow">
            <div class="action-group">
                <a class="btn btn-danger btn-action-bar" href="index.php?v=d&amp;p=plugin"><i class="fas fa-chevron-left spacing-right"></i>Retour</a>
                <a class="btn btn-success btn-action-bar eqLogicAction" id="bt_addEqLogic" data-action="add"><i class="fas fa-plus-circle spacing-right"></i>Ajouter</a>
            </div>
            <div class="action-group">
                <a class="btn btn-default btn-action-bar eqLogicAction" id="bt_gotoPluginConf" data-action="gotoPluginConf"><i class="fas fa-cog spacing-right"></i>Configuration</a>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fas fa-clone"></i>{{ 'Objets' }}</h3>
            </div>
            <div class="box-body">
                <div class="objectListContainer row">
                    <?php
                        foreach ($eqLogics as $eqLogic) {
                            $opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
                            echo '<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">';
                            echo '<div class="box objectDisplayCard w-icons" style="border-top:3px solid data-eqLogic_id="' . $eqLogic->getId() . '"data-object_name="' . $eqLogic->getHumanName(true, true) . '>';
                            echo '<a class="box-header with-border cursor">';
                            echo '</a>';
                            echo '<div class="box-body">';
                            echo '<span class="object-summary spacing-left"><img src="' . $plugin->getPathImgIcon() . '" height="105" width="95"/></span>';
                            echo '</div>';
                            echo '<div class="box-footer clearfix text-center">';
                            echo '<a class="btn btn-danger btn-sm pull-right remove bt_removeObject"><i class="fas fa-trash"></i></a>';
                            echo '<a class="btn btn-info btn-sm pull-left bt_detailsObject"><i class="fas fa-edit"></i></a>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                        ?>
                </div>
            </div>
        </div>
    </section>

    <section class="content" style="padding-top: 80px;">
        <div class="row row-overflow">

            <div class="col-lg-10 col-md-9 col-sm-8 eqLogicThumbnailDisplay"
                style="border-left: solid 1px #EEE; padding-left: 25px;">
                <legend><i class="fa fa-table"></i> {{Mes shutterss}}</legend>
                <div class="eqLogicThumbnailContainer">
                </div>
            </div>

            <div class="col-lg-10 col-md-9 col-sm-8 eqLogic"
                style="border-left: solid 1px #EEE; padding-left: 25px;display: none;">
                <a class="btn btn-success eqLogicAction pull-right" data-action="save">
                    <i class="fa fa-check-circle"></i> {{Sauvegarder}}
                </a>
                <a class="btn btn-danger eqLogicAction pull-right" data-action="remove">
                    <i class="fa fa-minus-circle"></i> {{Supprimer}}</a>
                <a class="btn btn-default eqLogicAction pull-right" data-action="configure">
                    <i class="fa fa-cogs"></i> {{Configuration avancée}}
                </a>
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation">
                        <a href="#" class="eqLogicAction" aria-controls="home" role="tab" data-toggle="tab"
                        data-action="returnToThumbnailDisplay">
                            <i class="fa fa-arrow-circle-left"></i>
                        </a>
                    </li>
                    <li role="presentation" class="active">
                        <a href="#eqlogictab" aria-controls="home" role="tab" data-toggle="tab">
                            <i class="fa fa-tachometer"></i> {{Equipement}}
                        </a>
                    </li>
                    <li role="presentation"><a href="#commandtab" aria-controls="profile" role="tab" data-toggle="tab">
                            <i class="fa fa-list-alt"></i> {{Commandes}}</a>
                    </li>
                </ul>
                <div class="tab-content" style="height:calc(100% - 50px);overflow:auto;overflow-x: hidden;">
                    <div role="tabpanel" class="tab-pane active" id="eqlogictab">
                        <br/>
                        <form class="form-horizontal">
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="name">{{Nom de l'équipement
                                        shutters}}</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="eqLogicAttr form-control" data-l1key="id"
                                            style="display : none;"/>
                                        <input type="text" class="eqLogicAttr form-control" data-l1key="name" id="name"
                                            placeholder="{{Nom de l'équipement shutters}}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="sel_object">{{Objet parent}}</label>
                                    <div class="col-sm-3">
                                        <select id="sel_object" class="eqLogicAttr form-control" data-l1key="object_id">
                                            <option value="">{{Aucun}}</option>
                                            <?php
                                            foreach (object::all() as $object) {
                                                echo '<option value="' . $object->getId() . '">' . $object->getName() . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">{{Catégorie}}</label>
                                    <div class="col-sm-9">
                                        <?php
                                        foreach (jeedom::getConfiguration('eqLogic:category') as $key => $value) {
                                            echo '<label class="checkbox-inline" for="category-' . $key . '">';
                                            echo '<input type="checkbox" id="category-' . $key . '" class="eqLogicAttr" data-l1key="category" data-l2key="' . $key . '" />' . $value['name'];
                                            echo '</label>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"></label>
                                    <div class="col-sm-9">
                                        <label class="checkbox-inline" for="is-enable">
                                            <input type="checkbox" class="eqLogicAttr" data-l1key="isEnable"
                                                checked="checked" id="is-enable"/>
                                            {{Activer}}
                                        </label>
                                        <label class="checkbox-inline" for="is-visible">
                                            <input type="checkbox" class="eqLogicAttr" data-l1key="isVisible"
                                                checked="checked" id="is-visible"/>
                                            {{Visible}}
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="shutters-param">{{shutters param
                                        1}}</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="eqLogicAttr form-control" id="shutters-param"
                                            data-l1key="configuration" data-l2key="city" placeholder="param1"/>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="commandtab">
                        <a class="btn btn-success btn-sm cmdAction pull-right" data-action="add" style="margin-top:5px;">
                            <i class="fa fa-plus-circle"></i> {{Commandes}}
                        </a>
                        <br/>
                        <br/>
                        <table id="table_cmd" class="table table-bordered table-condensed">
                            <thead>
                            <tr>
                                <th>{{Nom}}</th>
                                <th>{{Type}}</th>
                                <th>{{Action}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </section>

<?php
include_file('desktop', 'shutters', 'js', 'shutters');
include_file('core', 'plugin.template', 'js');

