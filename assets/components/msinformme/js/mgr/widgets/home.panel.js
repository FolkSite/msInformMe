msInformMe.panel.Home = function (config) {
    config = config || {};
    Ext.apply(config, {
        baseCls: 'modx-formpanel',
        layout: 'anchor',
        /*
         stateful: true,
         stateId: 'msinformme-panel-home',
         stateEvents: ['tabchange'],
         getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};},
         */
        hideMode: 'offsets',
        items: [{
            html: '<h2>' + _('msinformme') + '</h2>',
            cls: '',
            style: {margin: '15px 0'}
        }, {
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: true,
            hideMode: 'offsets',
            items: [{
                title: _('msinformme_items'),
                layout: 'anchor',
                items: [{
                    html: _('msinformme_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'msinformme-grid-items',
                    cls: 'main-wrapper',
                }]
            }]
        }]
    });
    msInformMe.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(msInformMe.panel.Home, MODx.Panel);
Ext.reg('msinformme-panel-home', msInformMe.panel.Home);
