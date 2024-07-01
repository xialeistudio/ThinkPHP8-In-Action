<?php
/**
 * File: AddAdmin.php
 * User: xialeistudio
 * Date: 2024/6/30
 **/

namespace app\command;

use app\service\AdminService;
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\Output;

class AddAdmin extends Command
{
    protected function configure()
    {
        $this->setName('admin:add')
            ->addArgument('username', Argument::REQUIRED, '账号')
            ->addArgument('password', Argument::REQUIRED, '密码')
            ->setDescription('添加管理员');
    }

    protected function execute(Input $input, Output $output)
    {
        $username = trim($input->getArgument('username'));
        if (empty($username)) {
            $output->error('账号不能为空');
            return;
        }
        $password = trim($input->getArgument('password'));
        if (empty($password)) {
            $output->error('密码不能为空');
            return;
        }
        try {
            AdminService::Factory()->register($username, $password);
            $output->info('添加管理员成功');
        } catch (\Exception $e) {
            $output->error($e->getMessage());
            return;
        }
    }
}