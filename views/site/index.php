<?php

/* @var $this yii\web\View */

$this->title = 'MoneySender';
?>
<div class="site-index">
    <div class="body-content" ng-app="msender" ng-controller="MoneySenderCtrl as MSender">
        <h2 class="text-center"><?= $this->title ?></h2>

        <div class="row">
            <div class="col-lg-4 text-center">
                <label>Отправитель:</label>
                <select class="form-control" ng-model="MSender.sender" ng-change="MSender.changeSender()">
                    <option ng-repeat="option in MSender.users" value="{{option.id}}">{{option.name}} ({{option.balance}})</option>
                </select>
            </div>
            <div class="col-lg-4 text-center">
                <label>Получатель:</label>
                <select class="form-control" ng-model="MSender.receiver">
                    <option ng-repeat="option in MSender.receivers" value="{{option.id}}">{{option.name}} ({{option.balance}})</option>
                </select>
            </div>
            <div class="col-lg-4 text-center">
                <label>Сумма:</label>
                <input type="number" id="amount" step="0.01" ng-model="MSender.amount" class="form-control" min="0">
            </div>
        </div>
        <div class="row text-center">
            <button class="btn btn-primary btn-lg text-center" ng-click="MSender.sendMoney()" style="margin-top: 1em">Отправить</button>
            <hr>
            <div id="result" class="hidden">
                <label for="compressed">Последние операции:</label>
                <table class="table col-lg-10">
                    <thead>
                    <tr>
                        <th class="col-lg-3 text-center">Отправитель</th>
                        <th class="col-lg-3 text-center">Получатель</th>
                        <th class="col-lg-2 text-center">Сумма</th>
                        <th class="col-lg-4 text-center">Результат</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-repeat="result in MSender.results">
                        <td class="col-lg-3 text-center" style="vertical-align: middle;">{{result.sender}}</td>
                        <td class="col-lg-3 text-center" style="vertical-align: middle;">{{result.receiver}}</td>
                        <td class="col-lg-2 text-center" style="vertical-align: middle;">{{result.amount}}</td>
                        <td class="col-lg-4 text-center" style="vertical-align: middle;">{{result.message}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
