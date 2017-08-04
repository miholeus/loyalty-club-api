/**
 * Нотификатор
 *
 * @param server сервер для соединения
 * @param login логин пользователя
 * @param token токен авторизации
 * @constructor
 */
var Notifier = function(server, login, token){
    this.server = server;
    this.token = token || null;
    this.login = login || null;
    this.connection = null;
    this.session = null;
    this.notes = new Array();
};
/**
 * Уведомления в браузере
 * @type {{notes: Array, get: Function, add: Function}}
 */
var Notes = {
    notes : [],
    get : function(topic) {
        return this.notes[topic] ? this.notes[topic] : null;
    },
    add : function(topic, note) {
        this.notes[topic] = note;
    },
    clear : function(topic) {
        if (this.notes[topic]) {
            delete this.notes[topic];
        }
    }
};

/**
 * Общий метод для подписки на каналы
 *
 * @param channel
 * @param callback
 */
Notifier.prototype.subscribe = function(channel, callback) {
    if (!('WebSocket' in window)) {
        console.warn("websockets not supported");
        return;
    }

    callback = callback || this.event;
    if (!this.connection) {
        this.connection = this.connect(function(session, details){
            session.subscribe(channel, callback);
        });
    } else {
        var onopen = this.connection.onopen;
        this.connection.onopen = function(session, details) {
            onopen(session, details);
            session.subscribe(channel, callback);
        }
    }
};
/**
 * Подключение к серверу
 *
 * @returns {*|k}
 */
Notifier.prototype.connect = function(cb) {
    var wsuri, self = this;

    wsuri = (document.location.protocol === "http:" ? "ws:" : "wss:") + "//" +
        this.server + "/ws";

    var httpUri;

    if (document.location.origin == "file://") {
        httpUri = "http://" + this.server + "/lp";

    } else {
        httpUri = (document.location.protocol === "http:" ? "http:" : "https:") + "//" +
            this.server + "/lp";
    }

    var onchallenge = function (session, method, extra) {

        console.log("onchallenge", method, extra);

        if (method === "ticket") {
            return self.token;
        } else {
            throw "don't know how to authenticate using '" + method + "'";
        }
    };

    // the WAMP connection to the Router
    var connection = new autobahn.Connection({
        // url: wsuri,
        transports: [
            {
                'type': 'websocket',
                'url': wsuri
            },
            {
                'type': 'longpoll',
                'url': httpUri
            }
        ],
        realm: "messaging",
        authmethods: ['ticket'],
        authid: this.login,
        onchallenge: onchallenge
    });

    connection.onopen = function (session, details) {
        console.log("connected");
        cb(session, details);
    };

    connection.onclose = function (reason, details) {
        console.log("connection closed ", reason, details);

        if (details.will_retry) {
            console.log("Trying to reconnect in " + parseInt(details.retry_delay) + " s.");
        } else {
            console.log("Disconnected");
        }
    };

    /* Opening the connection once all the callbacks are set */
    connection.open();

    return connection;
};

/**
 * Отписка от событий
 *
 * @param channel
 */
Notifier.prototype.unsubscribe = function(channel) {
    if (this.connection) {
        this.connection.unsubscribe(channel);
    }
};
/**
 * Подписка на обработку событий
 *
 * @param data
 */
Notifier.prototype.event = function(data) {
    console.log("Event: " + data);

    var tag = 'topic';
    var message = data[0];
    $.sticky(message, {
        autoclose: 3000,
        position: 'bottom-right',
        sticky: tag,
        closeCallback: function(){

        }
    });
    // $.stickyClose(note.id, 300);

    if ('Notification' in window) {
        // notification window
        Notification.requestPermission(function(permission) {
            var notification = new Notification("Новое уведомление",{body:message, tag : tag});

            if (undefined != notification) {
                setTimeout(function(){
                    notification.close(); //closes notification
                },2000);
                notification.onerror = function(){// fallback если отключены нотификации
                    if (message) {
                        $.sticky(message, {
                            autoclose: 5000,
                            position: 'bottom-right',
                            sticky: tag
                        });
                    }
                }
            }
        });
    }
};
