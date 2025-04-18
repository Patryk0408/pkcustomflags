<?php
/**
* 2007-2025 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2025 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

require_once _PS_MODULE_DIR_ . 'pkcustomflags/classes/Flag.php';

class AdminConfigurePkCustomFlagsController extends ModuleAdminController 
{
    public function initContent()
    {
        $this->fields_list['id_flag']['title'] = $this->trans('ID', [], 'Modules.PkCustomFlags.Admin');
        $this->fields_list['name']['title'] = $this->trans('Name', [], 'Modules.PkCustomFlags.Admin');
        $this->fields_list['text']['title'] = $this->trans('Text', [], 'Modules.PkCustomFlags.Admin');
        $this->fields_list['color']['title'] = $this->trans('Color', [], 'Modules.PkCustomFlags.Admin');

        parent::initContent();
    }

    public function __construct()
    {
        $this->bootstrap = true;
        $this->table = 'pk_custom_flags';
        $this->identifier = Flag::$definition['primary'];
        $this->lang = false;
        $this->context = Context::getContext();
        $this->className = 'Flag';

        $this->addRowAction('edit');
        $this->addRowAction('delete');
        $this->addRowAction('view');

        $this->content .= $this->renderList();

        $tpl_content = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'pkcustomflags/views/templates/admin/configure.tpl');
        $this->content .= $tpl_content;

        $this->context->smarty->assign([
            'content' => $this->content,
        ]);

        parent::__construct();
    }

    public function renderForm() {
        if($id_flag = Tools::getValue('id_flag')) {
            $flag = new Flag($id_flag);
            $this->field_value = [
                'name' => $flag->name,
                'text' => $flag->text,
                'color' => $flag->color
            ];
        }

        $this->fields_form = [
            'legend' => [
                'title' => 'New flag',
                'icon' => 'icon-flag'
            ],
            'input' => [
                [
                    'type' => 'text',
                    'label' => 'Name',
                    'name' => 'name',
                    'class' => 'input',
                    'required' => true,
                    'empty_message' => 'Please enter the name'
                ],
                [
                    'type' => 'text',
                    'label' => 'Text',
                    'name' => 'text',
                    'class' => 'input',
                    'required' => true,
                    'empty_message' => 'Please enter the text'
                ],
                [
                    'type' => 'color',
                    'label' => 'Color',
                    'name' => 'color',
                    'class' => 'input',
                    'required' => true,
                    'empty_message' => 'Please enter the color'
                ]
            ],
            'submit' => [
                    'title' => 'Save',
                    'class' => 'btn btn-primary pull-right'
            ]
        ];

        return parent::renderForm();
    }

    public function postProcess()
    {
        if (Tools::isSubmit('submitAdd' . $this->table)) {
            $id_flag = Tools::getValue('id_flag');
            $name = Tools::getValue('name');
            $text = Tools::getValue('text');
            $color = Tools::getValue('color');

            if (empty($name) || empty($text) || empty($color)) {
                $this->errors[] = $this->trans('All fields are required.', [], 'Modules.PkCustomFlags.Admin');
                return false;
            }

            $flag = $id_flag ? new Flag($id_flag) : new Flag();

            $flag->name = $name;
            $flag->text = $text;
            $flag->color = $color;

            if ($flag->save()) {
                $this->confirmations[] = $this->trans('The flag has been successfully saved.', [], 'Modules.PkCustomFlags.Admin');
            } else {
                $this->errors[] = $this->trans('An error occurred while saving the flag.', [], 'Modules.PkCustomFlags.Admin');
            }
        }

        parent::postProcess();
    }
}
