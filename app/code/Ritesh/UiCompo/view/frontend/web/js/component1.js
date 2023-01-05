define([
    'uiComponent',
    'ko'
 ],function (uiComponent,ko) {
     return uiComponent.extend(
        {
            _currentTime: ko.observable("loading"),
            initialize: function(){
                setInterval(this.updateTime.bind(this),1000);
            },
            getTime: function(){
                return this._currentTime;
            },
            updateTime: function(){
                this._currentTime(new Date());
            }
        }
     );
 });