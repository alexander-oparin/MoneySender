function MoneySenderCtrl($scope, $http) {
    var scope = this;

    $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded; charset=UTF-8';
    $http.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest';
    $http.defaults.transformRequest = [function (obj) {
        var str = [];
        for (var p in obj) {
            str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
        }
        return str.join("&");
    }];

    scope.sender = null;
    scope.receivers = [];
    scope.receiver = null;
    scope.amount = 0;
    scope.results = [];

    scope.changeSender = function () {
        var receivers = [];
        scope.users.forEach(function (user) {
            if (user.id != scope.sender) {
                receivers.push(user);
            }
        });
        scope.receivers = receivers;
        scope.receiver = scope.receivers[0].id;
    };

    scope.sendMoney = function () {
        var sender = scope.findUserIndex(scope.sender);
        var receiver = scope.findUserIndex(scope.receiver);
        var amount = scope.amount;

        if ((amount <= 0) || (amount > scope.users[sender].balance)) {
            alert('Сумма должна быть в пределах от 0 до ' + scope.users[sender].balance);
        } else {

            $http.post('/ajax/send-money', {
                sender: scope.sender,
                receiver: scope.receiver,
                amount: amount,
                _csrf: yii.getCsrfToken()
            }).then(function (data) {
                if (data.data.success == true) {
                    scope.users[sender].balance -= amount;
                    scope.users[receiver].balance = parseFloat(scope.users[receiver].balance) + parseFloat(amount);
                }
                angular.element('#result').removeClass('hidden');
                scope.results.push({
                    sender: scope.users[sender].name,
                    receiver: scope.users[receiver].name,
                    amount: amount,
                    message: data.data.error
                });
                console.log(data.data.error);
            });
        }
    };

    scope.findUserIndex = function (userId) {
        var i = 0, index = 0;
        scope.users.forEach(function (user) {
            if (user.id == userId) {
                index = i;
                return index;
            }
            i++;
        });
        return index;
    };

    $http.get('/ajax/get-users').then(function (data) {
        scope.users = data.data.users;
        scope.sender = scope.users[0].id;
        scope.changeSender();
    });
}

var msender = angular.module("msender", []);
msender.controller("MoneySenderCtrl", ['$scope', '$http', MoneySenderCtrl]);
