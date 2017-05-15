/*
  Create a new longPoll object with the following parameters
  @param {String} url: url on which longpoling is to be carried out
  @param {Object} payload: url parameters
  @param {function} callback: function to be carried out on success
  @param {function} payload_update: optional function to update the payload if necessary
 */
/* BEGIN--Long Polling Object definition--BEGIN */
var longPoll = function(url, payload, callback, payload_update) {
  if (typeof callback == 'function') {
    this.onAsyncComplete = callback;
  }

  this.url = url;
  this.payload = payload;
  this.stopRequest = undefined;

  this.sendReq = function(requestCallback) {
    if (typeof requestCallback == 'function') {
      this.updatePayload();
      $.getJSON(url, payload, function(data){
        requestCallback(data);
      });
    }
  }

  this.retry = function() {
    var currObj = this;
    if (currObj.stopRequest === undefined) {
      window.setTimeout(function(){
        currObj.start();
      }, 100000);
    }
  }

  this.updatePayload = function(){
    var p_update = payload_update();
    if (typeof p_update === 'object') {
      //console.log(p_update);
      //console.log('is-object');
      this.payload.lastModifiedTime = p_update.lastModifiedTime;
      this.payload.onlineDoctors = p_update.onlineDoctors;
    } else {
      this.payload.lastModifiedTime = p_update;
    }
  }
}

longPoll.prototype.start = function() {
  var currObj = this;
  //console.log('Polling started...');
  currObj.sendReq(function(data){
    //console.log(JSON.stringify(data) + " from inside start!");
    if (typeof data.status != 'undefined' && data.status == 1) {
      currObj.onAsyncComplete(data.data);
      currObj.retry();
    } else {
      currObj.retry();
    }
  });
};

longPoll.prototype.stop = function() {
  var currObj = this;
  currObj.stopRequest = 1;
}

longPoll.prototype.restart = function() {
  var currObj = this;
  if (currObj.stopRequest !== undefined) {
    currObj.stopRequest = undefined;
    currObj.start();
  };
}

/* END--Long Polling Object definition--END */