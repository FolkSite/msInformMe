var msInformMe = function (config) {
    config = config || {};
    msInformMe.superclass.constructor.call(this, config);
};
Ext.extend(msInformMe, Ext.Component, {
    page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}, view: {}, utils: {}
});
Ext.reg('msinformme', msInformMe);

msInformMe = new msInformMe();