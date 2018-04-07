Ext.ComponentMgr.onAvailable('modx-resource-main-right', function() {
    this.on('beforerender', function() {
        this.add({
            id: 'msinformme-pahel',
            layout: 'anchor',
            width: '100%',
            items: [{
                xtype: 'msinformme-item-panel'
            }]
        });
    });
});

msInformMe.panel.InformForm = function(config) {
    config = config || {};
    Ext.apply(config, {
        baseParams: {},
        items: [{
            layout: 'anchor',
            items: [{
                title: _('msinformme_open_send'),
                xtype: 'fieldset',
                cls: 'x-fieldset-checkbox-toggle',
                checkboxToggle: true,
                collapsed: Ext.state.Manager.get('msinformme-collapsed') != true ? false : true,
                forceLayout: true,
                listeners: {
                    'expand': {
                        fn: function (p) {
                            Ext.state.Manager.set('msinformme-collapsed', false);
                        }, scope: this
                    },
                    'collapse': {
                        fn: function (p) {
                            Ext.state.Manager.set('msinformme-collapsed', true);
                        }, scope: this
                    }
                },
                items: [{
                    tbar: this.getTopBar(config),
                }]
            }]
        }]
    });
    msInformMe.panel.InformForm.superclass.constructor.call(this, config);
};
Ext.extend(msInformMe.panel.InformForm, MODx.Panel, {

    getTopBar: function () {
        return [{
            xtype: 'textfield',
            vtype: 'email',
            id: 'msinformme-input-email',
            width: 250,
            name: 'im_email',
            emptyText: 'user@domain.com',
            style: {'padding': '5px'},
            value: miniShop2.msInformMe.im_email
        },{
            xtype: 'button',
            text: '<i class="icon icon-send"></i>&nbsp;&nbsp;' + _('msinformme_button_send'),
            handler: this.send,
        }];
    },

    send: function() {
        var email = Ext.getCmp('msinformme-input-email').getValue();
        var form = Ext.getCmp('modx-panel-resource').getForm();

        // Валидация Email
        var ereg = /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
        var result = ereg.test(email);

        if (MODx.isEmpty(email)) {
            return MODx.msg.alert(_('error'), _('msinformme_err_not_email'));
        } else if (!result) {
            return MODx.msg.alert(_('error'), _('msinformme_err_email_validate'));
        }
        // Отправить
        if (email) {
            MODx.msg.confirm({
                title: _('msinformme_open_send'),
                text: _('msinformme_send_question') + '<strong> ' + email + '</strong>',
                url: msInformMe.config.connector_url,
                params: {
                    action: 'mgr/send/send',
                    email: email,
                    id: form.record.id

                },
                listeners: {
                    success: {
                        fn: function (msg) {
                            MODx.msg.alert(_('success'), msg.message);
                        }
                    },
                    error: {
                        fn: function (msg) {
                            MODx.msg.alert(_('error'), msg);
                        }
                    }
                }
            });
        }
    }
});
Ext.reg('msinformme-item-panel', msInformMe.panel.InformForm);