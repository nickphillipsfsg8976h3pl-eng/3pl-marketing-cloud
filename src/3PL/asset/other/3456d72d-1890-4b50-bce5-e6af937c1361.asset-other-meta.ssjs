
  Platform.Load("core","1")

  var StateDE = DataExtension.Init("state");
  var data = StateDE.Rows.Lookup(["Active"], ["True"], 9999999, "State Code ASC");
  
  for (var i=0; i<data.length; i++) {
    delete data[i]._CustomObjectKey;
    delete data[i].Active;
  }//for
  
  Write(Stringify(data));

