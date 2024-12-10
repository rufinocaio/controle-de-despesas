<?php

use Pecee\SimpleRouter\SimpleRouter as Router;
use Cfurl\ControleDeDespesas\Controllers\AuthController;
use Cfurl\ControleDeDespesas\Controllers\ExpenseController;
use Cfurl\ControleDeDespesas\Controllers\DashboardController;
use Cfurl\ControleDeDespesas\Controllers\SettingController;

Router::get('/', [AuthController::class, 'login']);
Router::get('/dashboard', [DashboardController::class, 'index']);
Router::get('/adicionar-despesa', [ExpenseController::class, 'create']);
Router::post('/adicionar-despesa', [ExpenseController::class, 'create']);
Router::get('/editar-despesas', [ExpenseController::class, 'manageExpenses']);
Router::post('/salvar-despesa', [ExpenseController::class, 'edit']);
Router::post('/deletar-despesa', [ExpenseController::class, 'deleteExpense']);
Router::get('/perfil', [SettingController::class, 'settings']);
Router::post('/perfil', [SettingController::class, 'settings']);
Router::get('/logout', [AuthController::class, 'logout']);
Router::get('/registrar', [AuthController::class, 'register']);
Router::post('/registrar', [AuthController::class, 'register']);
Router::get('/login', [AuthController::class, 'login']);
Router::post('/login', [AuthController::class, 'login']);

Router::start();