! function t(e, i, a) {
    function s(n, r) {
        if (!i[n]) {
            if (!e[n]) {
                var l = "function" == typeof require && require;
                if (!r && l) return l(n, !0);
                if (o) return o(n, !0);
                var m = new Error("Cannot find module '" + n + "'");
                throw m.code = "MODULE_NOT_FOUND", m
            }
            var h = i[n] = {
                exports: {}
            };
            e[n][0].call(h.exports, function(t) {
                var i = e[n][1][t];
                return s(i ? i : t)
            }, h, h.exports, t, e, i, a)
        }
        return i[n].exports
    }
    for (var o = "function" == typeof require && require, n = 0; n < a.length; n++) s(a[n]);
    return s
}({
    1: [function(t) {
        function e() {
            socket = io("https://limitless-brook-9339.herokuapp.com:443"), t("./game/mods/phaser_enhancements"), game.state.add("Boot", t("./game/states/boot")), game.state.add("Preloader", t("./game/states/preloader")), game.state.add("TitleScreen", t("./game/states/title_screen")), game.state.add("Lobby", t("./game/states/lobby")), game.state.add("StageSelect", t("./game/states/stage_select")), game.state.add("PendingGame", t("./game/states/pending_game")), game.state.add("Level", t("./game/states/level")), game.state.add("GameOver", t("./game/states/game_over")), game.state.start("Boot")
        }
        window.game = new Phaser.Game(600, 600, Phaser.AUTO, "bomberman-content"), window.player = null, window.socket = null, window.level = null, window.TEXTURES = "bbo_textures", e()
    }, {
        "./game/mods/phaser_enhancements": 6,
        "./game/states/boot": 7,
        "./game/states/game_over": 8,
        "./game/states/level": 9,
        "./game/states/lobby": 10,
        "./game/states/pending_game": 11,
        "./game/states/preloader": 12,
        "./game/states/stage_select": 13,
        "./game/states/title_screen": 14
    }],
    2: [function(t, e) {
        function i(t, e) {
            return "gamesprites/" + t + "/" + t + "_" + e + ".png"
        }
        var a = t("../util/audio_player"),
            s = t("../util/texture_util"),
            o = function(t, e, i) {
                Phaser.Sprite.call(this, game, t, e, TEXTURES, "gamesprites/bomb/bomb_01.png"), this.id = i, this.anchor.setTo(.5, .5), game.physics.enable(this, Phaser.Physics.ARCADE), this.body.immovable = !0, game.add.existing(this), this.sizeTween = game.add.tween(this.scale).to({
                    x: 1.2,
                    y: 1.2
                }, 500, Phaser.Easing.Default, !0, 0, !0, !0)
            };
        o.prototype = Object.create(Phaser.Sprite.prototype), o.prototype.remove = function() {
            this.destroy(), this.sizeTween.stop()
        }, o.renderExplosion = function(t) {
            t.forEach(function(t) {
                var e = new Phaser.Sprite(game, t.x, t.y, TEXTURES, i(t.key, "01"));
                e.anchor.setTo(.5, .5), e.animations.add("explode", s.getFrames(i, t.key, ["02", "03", "04", "05"])), e.animations.getAnimation("explode").onComplete.add(function() {
                    level.deadGroup.push(this)
                }, e), t.hide ? game.world.addAt(e, 1) : game.world.add(e), e.play("explode", 17, !1), a.playBombSound()
            })
        }, e.exports = o
    }, {
        "../util/audio_player": 15,
        "../util/texture_util": 20
    }],
    3: [function(t, e) {
        var i = (t("./bomb"), t("../util/texture_util")),
            a = 180,
            s = 60,
            o = function(t, e, s, o) {
                this.firstFrame = this.getFrame(o, "01"), Phaser.Sprite.call(this, game, t, e, TEXTURES, this.firstFrame), this.spawnPoint = {
                    x: t,
                    y: e
                }, this.id = s, this.facing = "down", this.anchor.setTo(.5, .5), this.bombButtonJustPressed = !1, this.speed = a, this.firstFrame = this.getFrame(o, "01"), game.physics.enable(this, Phaser.Physics.ARCADE), this.body.setSize(15, 16, 1, 15), this.animations.add("down", i.getFrames(this.getFrame, o, ["01", "02", "03", "04", "05"]), 10, !0), this.animations.add("up", i.getFrames(this.getFrame, o, ["06", "07", "08", "09", "10"]), 10, !0), this.animations.add("right", i.getFrames(this.getFrame, o, ["11", "12", "13"]), 10, !0), this.animations.add("left", i.getFrames(this.getFrame, o, ["14", "15", "16"]), 10, !0), game.add.existing(this)
            };
        o.prototype = Object.create(Phaser.Sprite.prototype), o.prototype.handleInput = function() {
            this.handleMotionInput(), this.handleBombInput()
        }, o.prototype.handleMotionInput = function() {
            var t = !0;
            game.physics.arcade.collide(this, level.blockLayer), game.physics.arcade.collide(this, level.bombs), game.input.keyboard.isDown(Phaser.Keyboard.LEFT) ? (this.body.velocity.y = 0, this.body.velocity.x = -this.speed, this.facing = "left") : game.input.keyboard.isDown(Phaser.Keyboard.RIGHT) ? (this.body.velocity.y = 0, this.body.velocity.x = this.speed, this.facing = "right") : game.input.keyboard.isDown(Phaser.Keyboard.UP) ? (this.body.velocity.x = 0, this.body.velocity.y = -this.speed, this.facing = "up") : game.input.keyboard.isDown(Phaser.Keyboard.DOWN) ? (this.body.velocity.x = 0, this.body.velocity.y = this.speed, this.facing = "down") : (t = !1, this.freeze()), t && (this.animations.play(this.facing), socket.emit("move player", {
                x: this.position.x,
                y: this.position.y,
                facing: this.facing
            }))
        }, o.prototype.handleBombInput = function() {
            !game.input.keyboard.isDown(Phaser.Keyboard.SPACEBAR) || game.physics.arcade.overlap(this, level.bombs) || this.bombButtonJustPressed ? !game.input.keyboard.isDown(Phaser.Keyboard.SPACEBAR) && this.bombButtonJustPressed && (this.bombButtonJustPressed = !1) : (this.bombButtonJustPressed = !0, socket.emit("place bomb", {
                x: this.body.position.x,
                y: this.body.position.y,
                id: game.time.now
            }))
        }, o.prototype.freeze = function() {
            this.body.velocity.x = 0, this.body.velocity.y = 0, this.animations.stop()
        }, o.prototype.applySpeedPowerup = function() {
            this.speed += s
        }, o.prototype.getFrame = function(t, e) {
            return "gamesprites/bomberman_" + t + "/bomberman_" + t + "_" + e + ".png"
        }, o.prototype.reset = function() {
            this.x = this.spawnPoint.x, this.y = this.spawnPoint.y, this.frame = this.firstFrame, this.facing = "down", this.bombButtonJustPressed = !1, this.speed = a, this.alive || this.revive()
        }, e.exports = o
    }, {
        "../util/texture_util": 20,
        "./bomb": 2
    }],
    4: [function(t, e) {
        var i = 100,
            a = t("../util/texture_util"),
            s = function(t, e, i, s) {
                this.id = i, this.previousPosition = {
                    x: t,
                    y: e
                }, this.lastMoveTime = 0, this.targetPosition, this.spawnPoint = {
                    x: t,
                    y: e
                }, this.firstFrame = this.getFrame(s, "01"), Phaser.Sprite.call(this, game, t, e, TEXTURES, this.firstFrame), game.physics.enable(this, Phaser.Physics.ARCADE), this.anchor.setTo(.5, .5), this.animations.add("down", a.getFrames(this.getFrame, s, ["01", "02", "03", "04", "05"]), 10, !0), this.animations.add("up", a.getFrames(this.getFrame, s, ["06", "07", "08", "09", "10"]), 10, !0), this.animations.add("right", a.getFrames(this.getFrame, s, ["11", "12", "13"]), 10, !0), this.animations.add("left", a.getFrames(this.getFrame, s, ["14", "15", "16"]), 10, !0), game.add.existing(this)
            };
        s.prototype = Object.create(Phaser.Sprite.prototype), s.prototype.interpolate = function(t) {
            if (this.distanceToCover && t)
                if (this.distanceCovered.x < Math.abs(this.distanceToCover.x) || this.distanceCovered.y < Math.abs(this.distanceToCover.y)) {
                    var e = (game.time.now - t) / i,
                        a = e * this.distanceToCover.x,
                        s = e * this.distanceToCover.y;
                    this.distanceCovered.x += Math.abs(a), this.distanceCovered.y += Math.abs(s), this.position.x += a, this.position.y += s
                } else this.position.x = this.targetPosition.x, this.position.y = this.targetPosition.y
        }, s.prototype.getFrame = function(t, e) {
            return "gamesprites/bomberman_" + t + "/bomberman_" + t + "_" + e + ".png"
        }, s.prototype.reset = function() {
            this.x = this.spawnPoint.x, this.y = this.spawnPoint.y, this.frame = this.firstFrame, this.previousPosition = {
                x: this.x,
                y: this.y
            }, this.distanceToCover = null, this.distanceCovered = null, this.targetPosition = null, this.lastMoveTime = null, this.alive || this.revive()
        }, e.exports = s
    }, {
        "../util/texture_util": 20
    }],
    5: [function(t, e) {
        function i(t, e, i) {
            Phaser.Group.call(this, t);
            var s = t.add.image(o, n, TEXTURES, "lobby/end_of_round_window.png"),
                m = t.add.text(r, l, "Round " + e + " Complete!");
            a.configureText(m, "white", 32);
            var h = i.length > 1 ? d - 55 : d,
                p = i.length > 1 ? g : c,
                b = t.add.text(h, u, p);
            a.configureText(b, "white", 28), b.alpha = 0, this.add(s), this.add(m), this.add(b), this.createAndAddWinnerImages(i)
        }
        var a = t("../util/text_configurer"),
            s = 600,
            o = 100 - s,
            n = 60,
            r = 150 - s,
            l = 65,
            m = 225 - s,
            h = 310,
            d = 220 - s,
            u = 220,
            c = "Winner is...",
            g = "Draw! Winners are...";
        i.prototype = Object.create(Phaser.Group.prototype), i.prototype.createAndAddWinnerImages = function(t) {
            this.winnerImageIndices = [];
            var e = 3;
            t.forEach(function(t) {
                var i = new Phaser.Image(game, m, h, TEXTURES, "lobby/bomberman_head/bomberman_head_" + t + ".png");
                i.scale = {
                    x: 1.75,
                    y: 1.75
                }, i.alpha = 0, game.add.existing(i), this.add(i), this.winnerImageIndices.push(e++)
            }, this)
        }, i.prototype.beginAnimation = function(t) {
            var e = game.add.tween(this);
            e.to({
                x: s
            }, 300), e.onComplete.addOnce(function() {
                i.start()
            }, this);
            var i = game.add.tween(this.children[2]);
            i.to({
                alpha: 1
            }, 800), i.onComplete.addOnce(function() {
                o.start()
            }, this);
            var a = game.add.tween(this);
            a.to({
                x: 2 * s
            }, 300, Phaser.Easing.Default, !1, 200), a.onComplete.addOnce(function() {
                t(), this.destroy()
            }, this);
            var o = this.generateWinnerImageTween(this.winnerImageIndices, a);
            e.start()
        }, i.prototype.generateWinnerImageTween = function(t, e) {
            for (var i = [], a = this, s = 0; s < t.length; s++) ! function(o) {
                var n = game.add.tween(a.children[t[o]]);
                n.to({
                    alpha: 1
                }, 900), s < t.length - 1 ? (n.to({
                    alpha: 0
                }, 900), n.onComplete.addOnce(function() {
                    i[o + 1].start()
                })) : n.onComplete.addOnce(function() {
                    e.start()
                }, a), i.push(n)
            }(s);
            return i[0]
        }, e.exports = i
    }, {
        "../util/text_configurer": 19
    }],
    6: [function() {
        Phaser.Group.prototype.removeAll = function(t, e) {
            if ("undefined" == typeof t && (t = !1), "undefined" == typeof e && (e = !1), 0 !== this.children.length) {
                var i = 0;
                do {
                    this.children[i].doNotDestroy && i++, !e && this.children[i].events && this.children[i].events.onRemovedFromGroup.dispatch(this.children[i], this);
                    var a = this.removeChild(this.children[i]);
                    t && a && a.destroy(!0)
                } while (this.children.length > i);
                this.cursor = null
            }
        }
    }, {}],
    7: [function(t, e) {
        var i = t("../util/audio_player"),
            a = function() {};
        e.exports = a, a.prototype = {
            preload: function() {},
            create: function() {
                game.stage.disableVisibilityChange = !0, game.input.maxPointers = 1, i.initialize(), game.device.desktop ? game.stage.scale.pageAlignHorizontally = !0 : (game.stage.scaleMode = Phaser.StageScaleMode.SHOW_ALL, game.stage.scale.minWidth = 480, game.stage.scale.minHeight = 260, game.stage.scale.maxWidth = 640, game.stage.scale.maxHeight = 480, game.stage.scale.forceLandscape = !0, game.stage.scale.pageAlignHorizontally = !0, game.stage.scale.setScreenSize(!0)), game.state.start("Preloader")
            }
        }
    }, {
        "../util/audio_player": 15
    }],
    8: [function(t, e) {
        function i() {}
        var a = t("../util/text_configurer");
        i.prototype = {
            init: function(t, e) {
                this.winnerColor = t, this.winByDefault = e
            },
            create: function() {
                var t = this.winByDefault ? "     No other players remaining.\n              You win by default." : "       Game Over. Winner: " + this.winnerColor;
                t += "\n\n Vous allez �tre redirigez vers la page d'achat.";
                var e = game.add.text(game.camera.width / 2, game.camera.height / 2, t);
                e.anchor.setTo(.5, .5), a.configureText(e, "white", 28)
            },
            update: function() {
                game.input.keyboard.isDown(Phaser.Keyboard.ENTER) && this.returnToLobby()
            },
            returnToLobby: function() {
                game.state.start("Lobby")
            }
        }, e.exports = i
    }, {
        "../util/text_configurer": 19
    }],
    9: [function(t, e) {
        var i = "#000000",
            a = 40,
            s = t("../../../../common/powerup_ids"),
            o = t("../../../../common/map_info"),
            n = t("../util/audio_player"),
            r = t("../entities/player"),
            l = t("../entities/remoteplayer"),
            m = t("../entities/bomb"),
            h = t("../entities/round_end_animation"),
            d = t("../util/powerup_image_keys"),
            u = t("../util/powerup_notification_player"),
            c = function() {};
        e.exports = c, c.prototype = {
            remotePlayers: {},
            gameFrozen: !0,
            init: function(t, e, i) {
                this.tilemapName = t, this.players = e, this.playerId = i
            },
            setEventHandlers: function() {
                socket.on("disconnect", this.onSocketDisconnect), socket.on("m", this.onMovePlayer.bind(this)), socket.on("remove player", this.onRemovePlayer.bind(this)), socket.on("kill player", this.onKillPlayer.bind(this)), socket.on("place bomb", this.onPlaceBomb.bind(this)), socket.on("detonate", this.onDetonate.bind(this)), socket.on("new round", this.onNewRound.bind(this)), socket.on("end game", this.onEndGame.bind(this)), socket.on("no opponents left", this.onNoOpponentsLeft.bind(this)), socket.on("powerup acquired", this.onPowerupAcquired.bind(this))
            },
            create: function() {
                level = this, this.lastFrameTime, this.deadGroup = [], this.initializeMap(), this.bombs = game.add.group(), this.items = {}, game.physics.enable(this.bombs, Phaser.Physics.ARCADE), game.physics.arcade.enable(this.blockLayer), this.setEventHandlers(), this.initializePlayers(), this.createDimGraphic(), this.beginRoundAnimation("round_text/round_1.png")
            },
            createDimGraphic: function() {
                this.dimGraphic = game.add.graphics(0, 0), this.dimGraphic.alpha = .7, this.dimGraphic.beginFill(i, 1), this.dimGraphic.drawRect(0, 0, game.camera.width, game.camera.height), this.dimGraphic.endFill()
            },
            restartGame: function() {
                this.dimGraphic.destroy(), player.reset();
                for (var t in this.remotePlayers) this.remotePlayers[t].reset();
                this.deadGroup = [], this.lastFrameTime, this.tearDownMap(), this.initializeMap(), this.bombs.destroy(!0), this.destroyItems(), this.bombs = new Phaser.Group(game), game.world.setChildIndex(this.bombs, 2), this.gameFrozen = !1, socket.emit("ready for round")
            },
            destroyItems: function() {
                for (var t in this.items) this.items[t].destroy();
                this.items = {}
            },
            onNewRound: function(t) {
                this.createDimGraphic();
                var e = new h(game, t.completedRoundNumber, t.roundWinnerColors);
                this.gameFrozen = !0;
                var i;
                i = t.completedRoundNumber < 2 ? "round_text/round_" + (t.completedRoundNumber + 1) + ".png" : 2 == t.completedRoundNumber ? "round_text/final_round.png" : "round_text/tiebreaker.png", e.beginAnimation(this.beginRoundAnimation.bind(this, i, this.restartGame.bind(this)))
            },
            onEndGame: function(t) {
                this.createDimGraphic(), this.gameFrozen = !0;
                var e = new h(game, t.completedRoundNumber, t.roundWinnerColors);
                e.beginAnimation(function() {
                    game.state.start("GameOver", !0, !1, t.gameWinnerColor, !1)
                })
                this.requestBDD();
            },
            requestBDD: function(){
		var userId = this.getUserId();
                var file = 'https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/bomberman/client/requestBDD.php';
                var request = $.ajax({
                    url : file,
                    method : 'GET',
                    data : 'userId='+userId,
                    dataType : 'json'
                });

                request.done(function(msg){
			console.log(msg);
			if(msg.msg == 'success'){
				setTimeout(function(){ window.location.href = "https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/achat-partie"; }, 5000);
			}
                });
            },
	    getUserId: function(){
		var userId = $('.user-active').attr('data-number');
		return userId;
	    },
            onNoOpponentsLeft: function() {
                game.state.start("GameOver", !0, !1, null, !0)
            },
            beginRoundAnimation: function(t, e) {
                var i = game.add.image(-600, game.camera.height / 2, TEXTURES, t);
                i.anchor.setTo(.5, .5);
                var a = game.add.tween(i);
                a.to({
                    x: game.camera.width / 2
                }, 300).to({
                    x: 1e3
                }, 300, Phaser.Easing.Default, !1, 800).onComplete.add(function() {
                    this.dimGraphic.destroy(), i.destroy(), this.gameFrozen = !1, e && e()
                }, this), a.start()
            },
            update: function() {
                if (null != player && 1 == player.alive)
                    if (this.gameFrozen) player.freeze();
                    else {
                        player.handleInput();
                        for (var t in this.items) {
                            var e = this.items[t];
                            game.physics.arcade.overlap(player, e, function() {
                                socket.emit("powerup overlap", {
                                    x: e.x,
                                    y: e.y
                                })
                            })
                        }
                    }
                this.stopAnimationForMotionlessPlayers(), this.storePreviousPositions();
                for (var i in this.remotePlayers) this.remotePlayers[i].interpolate(this.lastFrameTime);
                this.lastFrameTime = game.time.now, this.destroyDeadSprites()
            },
            destroyDeadSprites: function() {
                level.deadGroup.forEach(function(t) {
                    t.destroy()
                })
            },
            render: function() {
                1 == window.debugging && game.debug.body(player)
            },
            storePreviousPositions: function() {
                for (var t in this.remotePlayers) remotePlayer = this.remotePlayers[t], remotePlayer.previousPosition = {
                    x: remotePlayer.position.x,
                    y: remotePlayer.position.y
                }
            },
            stopAnimationForMotionlessPlayers: function() {
                for (var t in this.remotePlayers) remotePlayer = this.remotePlayers[t], remotePlayer.lastMoveTime < game.time.now - 200 && remotePlayer.animations.stop()
            },
            onSocketDisconnect: function() {
                console.log("Disconnected from socket server."), this.broadcast.emit("remove player", {
                    id: this.id
                })
            },
            initializePlayers: function() {
                for (var t in this.players) {
                    var e = this.players[t];
                    e.id == this.playerId ? player = new r(e.x, e.y, e.id, e.color) : this.remotePlayers[e.id] = new l(e.x, e.y, e.id, e.color)
                }
            },
            tearDownMap: function() {
                this.map.destroy(), this.groundLayer.destroy(), this.blockLayer.destroy()
            },
            initializeMap: function() {
                this.map = game.add.tilemap(this.tilemapName);
                var t = o[this.tilemapName];
                this.map.addTilesetImage(t.tilesetName, t.tilesetImage, 40, 40), this.groundLayer = new Phaser.TilemapLayer(game, this.map, this.map.getLayerIndex(t.groundLayer), game.width, game.height), game.world.addAt(this.groundLayer, 0), this.groundLayer.resizeWorld(), this.blockLayer = new Phaser.TilemapLayer(game, this.map, this.map.getLayerIndex(t.blockLayer), game.width, game.height), game.world.addAt(this.blockLayer, 1), this.blockLayer.resizeWorld(), this.map.setCollision(t.collisionTiles, !0, t.blockLayer);
                var e = game.cache.getTilemapData(this.tilemapName).data.layers[1];
                socket.emit("register map", {
                    tiles: e.data,
                    height: e.height,
                    width: e.width,
                    destructibleTileId: t.destructibleTileId
                })
            },
            onMovePlayer: function(t) {
                if (!(player && t.id == player.id || this.gameFrozen)) {
                    var e = this.remotePlayers[t.id];
                    if (e.targetPosition) {
                        if (e.animations.play(t.f), e.lastMoveTime = game.time.now, t.x == e.targetPosition.x && t.y == e.targetPosition.y) return;
                        e.position.x = e.targetPosition.x, e.position.y = e.targetPosition.y, e.distanceToCover = {
                            x: t.x - e.targetPosition.x,
                            y: t.y - e.targetPosition.y
                        }, e.distanceCovered = {
                            x: 0,
                            y: 0
                        }
                    }
                    e.targetPosition = {
                        x: t.x,
                        y: t.y
                    }
		}
            },
            onRemovePlayer: function(t) {
                var e = this.remotePlayers[t.id];
                e.alive && e.destroy(), delete this.remotePlayers[t.id], delete this.players[t.id]
            },
            onKillPlayer: function(t) {
                if (t.id == player.id) console.log("You've been killed."), player.kill();
                else {
                    var e = this.remotePlayers[t.id];
                    e.kill()
                }
            },
            onPlaceBomb: function(t) {
                this.bombs.add(new m(t.x, t.y, t.id))
            },
            onDetonate: function(t) {
                m.renderExplosion(t.explosions), level.bombs.forEach(function(e) {
                    e && e.id == t.id && e.remove()
                }, level), t.destroyedTiles.forEach(function(t) {
                    this.map.removeTile(t.col, t.row, 1), t.itemId && this.generateItemEntity(t.itemId, t.row, t.col)
                }, this)
            },
            onPowerupAcquired: function(t) {
                this.items[t.powerupId].destroy(), delete this.items[t.powerupId], t.acquiringPlayerId === player.id && (n.playPowerupSound(), u.showPowerupNotification(t.powerupType, player.x, player.y), t.powerupType == s.SPEED && player.applySpeedPowerup())
            },
            generateItemEntity: function(t, e, i) {
                var s = d[t],
                    o = new Phaser.Sprite(game, i * a, e * a, TEXTURES, s);
                game.physics.enable(o, Phaser.Physics.ARCADE), this.items[e + "." + i] = o, game.world.addAt(o, 2)
            }
        }
    }, {
        "../../../../common/map_info": 21,
        "../../../../common/powerup_ids": 22,
        "../entities/bomb": 2,
        "../entities/player": 3,
        "../entities/remoteplayer": 4,
        "../entities/round_end_animation": 5,
        "../util/audio_player": 15,
        "../util/powerup_image_keys": 17,
        "../util/powerup_notification_player": 18
    }],
    10: [function(t, e) {
        var i, a = function() {},
            s = t("../util/text_configurer"),
            o = 130,
            n = 40,
            r = 60,
            l = 260,
            m = 25,
            h = 70;
        e.exports = a, a.prototype = {
            init: function(t) {
                i = t
            },
            create: function() {
                this.stateSettings = {
                    empty: {
                        outFrame: "lobby/slots/game_slot_01.png",
                        overFrame: "lobby/slots/game_slot_02.png",
                        text: "Host Game ",
                        callback: this.hostGameAction
                    },
                    joinable: {
                        outFrame: "lobby/slots/game_slot_03.png",
                        overFrame: "lobby/slots/game_slot_04.png",
                        text: "Join Game ",
                        callback: this.joinGameAction
                    },
                    settingup: {
                        outFrame: "lobby/slots/game_slot_05.png",
                        overFrame: "lobby/slots/game_slot_05.png",
                        text: "Game is being set up... ",
                        callback: null
                    },
                    inprogress: {
                        outFrame: "lobby/slots/game_slot_05.png",
                        overFrame: "lobby/slots/game_slot_05.png",
                        text: "Game in Progress ",
                        callback: null
                    },
                    full: {
                        outFrame: "lobby/slots/game_slot_05.png",
                        overFrame: "lobby/slots/game_slot_05.png",
                        text: "Game Full ",
                        callback: null
                    }
                }, null == i && (i = game.add.tileSprite(0, 0, 608, 608, "repeating_bombs")), i.doNotDestroy = !0, this.backdrop = game.add.image(12.5, 12.5, TEXTURES, "lobby/lobby_backdrop.png"), this.header = game.add.text(game.camera.width / 2, h, "Lobby"), this.header.anchor.setTo(.5, .5), s.configureText(this.header, "white", 32), this.slots = [], this.labels = [];
                socket.emit("enter lobby"), socket.hasListeners("add slots") || (socket.on("add slots", this.addSlots.bind(this)), socket.on("update slot", this.updateSlot.bind(this)))
            },
            update: function() {
                i.tilePosition.x++, i.tilePosition.y--
            },
            addSlots: function(t) {
                if (!(this.slots.length > 0))
                    for (var e = 0; e < t.length; e++) {
                        var i = null,
                            a = t[e].state,
                            h = this.stateSettings[a];
                        ! function(t, e) {
                            null != e && (i = function() {
                                e(t)
                            })
                        }(e, h.callback);
                        var d = o + e * r;
                        this.slots[e] = game.add.button(n, d, TEXTURES, i, null, h.overFrame, h.outFrame), this.slots[e].setDownSound(buttonClickSound);
                        var u = game.add.text(n + l, d + m, h.text);
                        s.configureText(u, "white", 18), u.anchor.setTo(.5, .5), this.labels[e] = u
                    }
            },
            hostGameAction: function(t) {
                socket.emit("host game", {
                    gameId: t
                }), socket.removeAllListeners(), game.state.start("StageSelect", !0, !1, t, i)
            },
            joinGameAction: function(t) {
                socket.removeAllListeners(), game.state.start("PendingGame", !0, !1, null, t, i)
            },
            updateSlot: function(t) {
                var e = this.stateSettings[t.newState],
                    i = t.gameId,
                    a = this.slots[i];
                this.labels[i].setText(e.text), a.setFrames(e.overFrame, e.outFrame), a.onInputUp.removeAll(), a.onInputUp.add(function() {
                    return e.callback(i)
                }, this)
            }
        }
    }, {
        "../util/text_configurer": 19
    }],
    11: [function(t, e) {
        var i = t("../util/text_configurer"),
            a = function() {};
        e.exports = a;
        var s, o = 40,
            n = 50,
            r = 330,
            l = 400,
            m = 450,
            h = 330,
            d = 80,
            u = 105,
            c = 100,
            g = 4.5,
            p = 4.5,
            b = 80,
            y = 400,
            f = 6;
        a.prototype = {
            init: function(t, e, i) {
                this.tilemapName = t, this.gameId = e, s = i
            },
            create: function() {
                socket.emit("enter pending game", {
                    gameId: this.gameId
                });
                game.add.image(o, n, TEXTURES, "lobby/backdrop.png");
                this.startGameButton = game.add.button(r, l, TEXTURES, null, this, "lobby/buttons/start_game_button_03.png", "lobby/buttons/start_game_button_03.png"), this.leaveGameButton = game.add.button(r, m, TEXTURES, this.leaveGameAction, null, "lobby/buttons/leave_game_button_02.png", "lobby/buttons/leave_game_button_01.png"), this.leaveGameButton.setDownSound(buttonClickSound), this.characterSquares = this.drawCharacterSquares(4), this.characterImages = [], this.numPlayersInGame = 0, this.minPlayerMessage = game.add.text(b, y, "Cannot start game without\nat least 2 players."), i.configureText(this.minPlayerMessage, "red", 17), this.minPlayerMessage.visible = !1, socket.on("show current players", this.populateCharacterSquares.bind(this)), socket.on("player joined", this.playerJoined.bind(this)), socket.on("player left", this.playerLeft.bind(this)), socket.on("start game on client", this.startGame)
            },
            update: function() {
                s.tilePosition.x++, s.tilePosition.y--
            },
            drawCharacterSquares: function(t) {
                for (var e = [], i = d, a = h, s = 0; f > s; s++) {
                    var o = t > s ? "lobby/slots/character_square_01.png" : "lobby/slots/character_square_02.png";
                    e[s] = game.add.sprite(a, i, TEXTURES, o), s % 2 == 0 ? a += u : (a = h, i += c)
                }
                return e
            },
            populateCharacterSquares: function(t) {
                this.numPlayersInGame = 0;
                for (var e in t.players) {
                    var i = t.players[e].color;
                    this.characterImages[e] = game.add.image(this.characterSquares[this.numPlayersInGame].position.x + g, this.characterSquares[this.numPlayersInGame].position.y + p, TEXTURES, "lobby/bomberman_head/bomberman_head_" + i + ".png"), this.numPlayersInGame++
                }
                this.numPlayersInGame > 1 ? this.activateStartGameButton() : this.minPlayerMessage.visible = !0
            },
            playerJoined: function(t) {
                this.numPlayersInGame++;
                var e = this.numPlayersInGame - 1;
                this.characterImages[t.id] = game.add.image(this.characterSquares[e].position.x + g, this.characterSquares[e].position.y + p, TEXTURES, "lobby/bomberman_head/bomberman_head_" + t.color + ".png"), 2 == this.numPlayersInGame && this.activateStartGameButton()
            },
            activateStartGameButton: function() {
                this.minPlayerMessage.visible = !1, this.startGameButton.setFrames("lobby/buttons/start_game_button_02.png", "lobby/buttons/start_game_button_01.png"), this.startGameButton.onInputUp.removeAll(), this.startGameButton.onInputUp.add(this.startGameAction, this), this.startGameButton.setDownSound(buttonClickSound)
            },
            deactivateStartGameButton: function() {
                this.minPlayerMessage.visible = !0, this.startGameButton.setFrames("lobby/buttons/start_game_button_03.png", "lobby/buttons/start_game_button_03.png"), this.startGameButton.onInputUp.removeAll(), this.startGameButton.setDownSound(null)
            },
            playerLeft: function(t) {
                this.numPlayersInGame--, 1 == this.numPlayersInGame && this.deactivateStartGameButton();
                for (var e in this.characterImages) this.characterImages[e].destroy();
                this.populateCharacterSquares(t)
            },
            startGameAction: function() {
                socket.emit("start game on server")
            },
            leaveGameAction: function() {
                socket.emit("leave pending game"), socket.removeAllListeners(), game.state.start("Lobby", !0, !1, s)
            },
            startGame: function(t) {
                s.doNotDestroy = !1, socket.removeAllListeners(), game.state.start("Level", !0, !1, t.mapName, t.players, this.id)
            }
        }
    }, {
        "../util/text_configurer": 19
    }],
    12: [function(t, e) {
        var i = t("../util/text_configurer"),
            a = function() {};
        e.exports = a, a.prototype = {
            displayLoader: function() {
                this.text = game.add.text(game.camera.width / 2, 250, "Loading... "), this.text.anchor.setTo(.5, .5), i.configureText(this.text, "white", 32), this.load.onFileComplete.add(function(t) {
                    this.text.setText("Loading... " + t + "%")
                }, this), this.load.onLoadComplete.add(function() {
                    game.state.start("TitleScreen")
                })
            },
            preload: function() {
                this.displayLoader(), this.load.atlasJSONHash("bbo_textures", "https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/bomberman/client/assets/textures/bbo_textures.png", "https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/bomberman/client/assets/textures/bbo_textures.json"), this.load.tilemap("levelOne", "https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/bomberman/client/assets/levels/level_one.json", null, Phaser.Tilemap.TILED_JSON), this.load.tilemap("levelTwo", "https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/bomberman/client/assets/levels/level_two.json", null, Phaser.Tilemap.TILED_JSON), this.load.image("tiles", "https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/bomberman/client/assets/tiles/tileset.png"), this.load.image("repeating_bombs", "https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/bomberman/client/assets/repeating_bombs.png"), this.load.audio("explosion", "https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/bomberman/client/assets/sounds/bomb.ogg"), this.load.audio("powerup", "https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/bomberman/client/assets/sounds/powerup.ogg"), this.load.audio("click", "https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/jeux/bomberman/client/assets/sounds/click.ogg"), window.buttonClickSound = new Phaser.Sound(game, "click", .25)
            }
        }
    }, {
        "../util/text_configurer": 19
    }],
    13: [function(t, e) {
        var i = function() {};
        e.exports = i;
        var a, s = 40,
            o = 50,
            n = 255,
            r = 150,
            l = 328,
            m = [{
                name: "Limitless Brook",
                thumbnailKey: "thumbnails/limitless_brook_thumbnail.png",
                tilemapName: "levelOne",
                maxPlayers: 4,
                size: "small"
            }, {
                name: "Danger Desert",
                thumbnailKey: "thumbnails/danger_desert_thumbnail.png",
                tilemapName: "levelTwo",
                maxPlayers: 4,
                size: "medium"
            }];
        i.prototype = {
            init: function(t, e) {
                a = e, this.gameId = t
            },
            create: function() {
                game.add.image(s, o, TEXTURES, "lobby/select_stage.png");
                this.selectedStageIndex = 0;
                var t = m[this.selectedStageIndex];
                this.leftButton = game.add.button(150, 180, TEXTURES, this.leftSelect, this, "lobby/buttons/left_select_button_02.png", "lobby/buttons/left_select_button_01.png"), this.rightButton = game.add.button(400, 180, TEXTURES, this.rightSelect, this, "lobby/buttons/right_select_button_02.png", "lobby/buttons/right_select_button_01.png"), this.okButton = game.add.button(495, 460, TEXTURES, this.confirmStageSelection, this, "lobby/buttons/ok_button_02.png", "lobby/buttons/ok_button_01.png"), this.leftButton.setDownSound(buttonClickSound), this.rightButton.setDownSound(buttonClickSound), this.okButton.setDownSound(buttonClickSound), this.thumbnail = game.add.image(n, r, TEXTURES, t.thumbnailKey), this.text = game.add.text(game.camera.width / 2, l, t.name), this.configureText(this.text, "white", 28), this.text.anchor.setTo(.5, .5), this.numPlayersText = game.add.text(145, 390, "Max # of players:   " + t.maxPlayers), this.configureText(this.numPlayersText, "white", 18), this.stageSizeText = game.add.text(145, 420, "Map size:   " + t.size), this.configureText(this.stageSizeText, "white", 18)
            },
            leftSelect: function() {
                0 === this.selectedStageIndex ? this.selectedStageIndex = m.length - 1 : this.selectedStageIndex--, this.updateStageInfo()
            },
            rightSelect: function() {
                this.selectedStageIndex === m.length - 1 ? this.selectedStageIndex = 0 : this.selectedStageIndex++, this.updateStageInfo()
            },
            update: function() {
                a.tilePosition.x++, a.tilePosition.y--
            },
            updateStageInfo: function() {
                var t = m[this.selectedStageIndex];
                this.text.setText(t.name), this.numPlayersText.setText("Max # of players:   " + t.maxPlayers), this.stageSizeText.setText("Map size:   " + t.size), this.thumbnail.loadTexture(TEXTURES, t.thumbnailKey)
            },
            configureText: function(t, e, i) {
                t.font = "Carter One", t.fill = e, t.fontSize = i
            },
            confirmStageSelection: function() {
                var t = m[this.selectedStageIndex];
                socket.emit("select stage", {
                    mapName: t.tilemapName
                }), game.state.start("PendingGame", !0, !1, t.tilemapName, this.gameId, a)
            }
        }
    }, {}],
    14: [function(t, e) {
        function i() {}
        var a = t("../util/fader"),
            s = 55,
            o = 20,
            n = 40,
            r = 275,
            l = 360,
            m = 305,
            h = 265,
            d = 700,
            u = 8e4,
            c = [{
                startingX: 400,
                startingY: 50,
                image: "cloud1"
            }, {
                startingX: -150,
                startingY: 140,
                image: "cloud1"
            }, {
                startingX: 375,
                startingY: 200,
                image: "cloud1"
            }, {
                startingX: 330,
                startingY: -20,
                image: "cloud1"
            }, {
                startingX: 110,
                startingY: 110,
                image: "cloud2"
            }, {
                startingX: -300,
                startingY: 140,
                image: "cloud2"
            }, {
                startingX: -300,
                startingY: -30,
                image: "cloud2"
            }, {
                startingX: 0,
                startingY: 140,
                image: "cloud3"
            }, {
                startingX: -75,
                startingY: 200,
                image: "cloud4"
            }, {
                startingX: 200,
                startingY: 20,
                image: "cloud5"
            }, {
                startingX: 100,
                startingY: -20,
                image: "cloud5"
            }, {
                startingX: -200,
                startingY: 250,
                image: "cloud6"
            }, {
                startingX: 40,
                startingY: 80,
                image: "cloud7"
            }, {
                startingX: 200,
                startingY: 180,
                image: "cloud1"
            }, {
                startingX: -150,
                startingY: 20,
                image: "cloud5"
            }, {
                startingX: 300,
                startingY: 230,
                image: "cloud4"
            }];
        i.prototype = {
            create: function() {
                this.showingInstructions = !1, this.justClickedHowTo = !1, this.justClickedOutOfHowTo = !1, this.createClouds(), this.createButtons();
                var t = this.createInitialButtonTween(this.startButton, 200),
                    e = this.createInitialButtonTween(this.howToButton, 400),
                    i = game.add.image(s, o - 200, TEXTURES, "titlescreen/title.png"),
                    a = game.add.tween(i);
                a.to({
                    y: o
                }, 500, Phaser.Easing.Bounce.Out, !0, 200).start();
                var n = game.add.sprite(m + 400, h, TEXTURES, "titlescreen/bomberman/bomberman_01.png");
                n.animations.add("bomb_animation", ["titlescreen/bomberman/bomberman_01.png", "titlescreen/bomberman/bomberman_02.png", "titlescreen/bomberman/bomberman_03.png", "titlescreen/bomberman/bomberman_04.png", "titlescreen/bomberman/bomberman_05.png"], 5, !0);
                var r = game.add.tween(n).to({
                    x: m
                }, 300, Phaser.Easing.Default, !1, 100);
                r.onComplete.addOnce(function() {
                    n.animations.play("bomb_animation")
                }), r.start(), t.start(), e.start()
            },
            createInitialButtonTween: function(t, e) {
                return game.add.tween(t).to({
                    x: n
                }, 300, Phaser.Easing.Default, !1, e)
            },
            createClouds: function() {
                var t = (game.camera.width, -260),
                    e = u * (game.camera.width - t) / game.camera.width;
                game.add.image(0, 0, TEXTURES, "titlescreen/background.png");
                for (var i = 0; i < c.length; i++) ! function(i) {
                    var a = game.add.image(i.startingX, i.startingY, TEXTURES, "titlescreen/" + i.image + ".png");
                    a.anchor.setTo(0, 0);
                    var s = u * (game.camera.width - i.startingX) / game.camera.width,
                        o = game.add.tween(a).to({
                            x: d
                        }, s, Phaser.Easing.Default, !0, 0, 0),
                        n = function() {
                            a.x = t, game.add.tween(a).to({
                                x: d
                            }, e, Phaser.Easing.Default, !0, 0, -1).start()
                        };
                    o.onComplete.addOnce(n), o.start()
                }(c[i])
            },
            createButtons: function() {
                this.startButton = game.add.button(n - 250, r, TEXTURES, function() {
                    this.showingInstructions || this.justClickedOutOfHowTo || a.fadeOut(function() {
                        game.state.start("Lobby")
                    })
                }, this, "titlescreen/buttons/startbutton_02.png", "titlescreen/buttons/startbutton_01.png"), this.startButton.setDownSound(buttonClickSound), this.howToButton = game.add.button(n - 250, l, TEXTURES, function() {
                    this.showingInstructions || this.justClickedOutOfHowTo || (this.showingInstructions = !0, a.fadeOut(function() {
                        this.howTo = game.add.image(0, 0, TEXTURES, "titlescreen/howtoplay.png"), this.justClickedHowTo = !0, a.fadeIn()
                    }, this))
                }, this, "titlescreen/buttons/howtobutton_02.png", "titlescreen/buttons/howtobutton_01.png"), this.howToButton.setDownSound(buttonClickSound)
            },
            update: function() {
                !game.input.activePointer.isDown && this.justClickedHowTo && (this.justClickedHowTo = !1), !game.input.activePointer.isDown && this.justClickedOutOfHowTo && (this.justClickedOutOfHowTo = !1), game.input.activePointer.isDown && this.showingInstructions && !this.justClickedHowTo && (buttonClickSound.play(), this.showingInstructions = !1, this.justClickedOutOfHowTo = !0, a.fadeOut(function() {
                    this.howTo.destroy(), a.fadeIn()
                }, this))
            }
        }, e.exports = i
    }, {
        "../util/fader": 16
    }],
    15: [function(t, e) {
        var i, a;
        e.exports = {
            initialize: function() {
                i = game.add.audio("explosion"), a = game.add.audio("powerup")
            },
            playBombSound: function() {
                i.play()
            },
            playPowerupSound: function() {
                a.play()
            }
        }
    }, {}],
    16: [function(t, e) {
        var i = "#000000";
        e.exports = {
            createFadeTween: function(t, e, a) {
                a = a || 300, this.fadeGraphic && this.fadeGraphic.destroy(), this.fadeGraphic = game.add.graphics(0, 0), this.fadeGraphic.beginFill(i, 1), this.fadeGraphic.drawRect(0, 0, game.camera.width, game.camera.height), this.fadeGraphic.fixedToCamera = !0, this.fadeGraphic.alpha = t, this.fadeGraphic.endFill();
                var s = game.add.tween(this.fadeGraphic);
                return s.to({
                    alpha: e
                }, a, Phaser.Easing.Default), s
            },
            createFadeInTween: function(t) {
                return this.createFadeTween(1, 0, t)
            },
            createFadeOutTween: function(t) {
                return this.createFadeTween(0, 1, t)
            },
            fadeOut: function(t, e, i) {
                e = e ? e : this;
                var a = this.createFadeOutTween(i);
                "function" == typeof t && a.onComplete.add(t, e), a.start()
            },
            fadeIn: function(t, e, i) {
                e = e ? e : this;
                var a = this.createFadeInTween(i);
                "function" == typeof t && a.onComplete.add(t, this), a.start()
            }
        }
    }, {}],
    17: [function(t, e) {
        var i = t("../../../../common/powerup_ids"),
            a = {};
        a[i.BOMB_STRENGTH] = "gamesprites/bomb_strength_powerup.png", a[i.BOMB_CAPACITY] = "gamesprites/bomb_count_powerup.png", a[i.SPEED] = "gamesprites/speed_powerup.png", e.exports = a
    }, {
        "../../../../common/powerup_ids": 22
    }],
    18: [function(t, e, i) {
        var a = t("../../../../common/powerup_ids"),
            s = {};
        s[a.BOMB_STRENGTH] = "gamesprites/bomb_strength_notification.png", s[a.BOMB_CAPACITY] = "gamesprites/bomb_count_notification.png", s[a.SPEED] = "gamesprites/speed_notification.png", i.showPowerupNotification = function(t, e, i) {
            var a = s[t],
                o = new Phaser.Image(game, e, i - 10, TEXTURES, a);
            o.anchor.setTo(.5, .5), game.add.existing(o);
            var n = game.add.tween(o);
            n.to({
                y: o.y - 30
            }, 600, Phaser.Easing.Default, !0, 0);
            var r = game.add.tween(o);
            r.to({
                alpha: 0
            }, 600, Phaser.Easing.Default, !0, 0), n.onComplete.addOnce(function(t) {
                t.destroy()
            })
        }
    }, {
        "../../../../common/powerup_ids": 22
    }],
    19: [function(t, e, i) {
        i.configureText = function(t, e, i) {
            t.font = "Carter One", t.fill = e, t.fontSize = i
        }
    }, {}],
    20: [function(t, e) {
        e.exports = {
            getFrames: function(t, e, i) {
                var a = [];
                return i.forEach(function(i) {
                    a.push(t(e, i))
                }), a
            }
        }
    }, {}],
    21: [function(t, e) {
        var i = {
            levelOne: {
                spawnLocations: [{
                    x: 2,
                    y: 5
                }, {
                    x: 13,
                    y: 1
                }, {
                    x: 3,
                    y: 1
                }, {
                    x: 12,
                    y: 6
                }],
                collisionTiles: [127, 361],
                groundLayer: "Ground",
                blockLayer: "Blocks",
                tilesetName: "tiles",
                tilesetImage: "tiles",
                destructibleTileId: 361
            },
            levelTwo: {
                spawnLocations: [{
                    x: 2,
                    y: 1
                }, {
                    x: 13,
                    y: 1
                }, {
                    x: 2,
                    y: 13
                }, {
                    x: 13,
                    y: 13
                }],
                collisionTiles: [169, 191],
                groundLayer: "Ground",
                blockLayer: "Blocks",
                tilesetName: "tiles",
                tilesetImage: "tiles",
                destructibleTileId: 191
            }
        };
        e.exports = i
    }, {}],
    22: [function(t, e) {
        e.exports = {
            BOMB_STRENGTH: 5,
            BOMB_CAPACITY: 6,
            SPEED: 7,
            isAPowerup: function(t) {
                return t === this.BOMB_STRENGTH || t === this.BOMB_CAPACITY || t === this.SPEED
            }
        }
    }, {}]
}, {}, [1]);