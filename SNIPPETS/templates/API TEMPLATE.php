<script runat="server">
    Platform.Load("core", "1");

    try {

        // get params
        var country_code = Request.GetQueryStringParameter("country_code");


        // find table
        var table = DataExtension.Init("state");


        // run query
        var data;
        if (country_code) {
            data = table.Rows.Lookup(["Country Code", "Active"], [country_code, "True"], 1000, "State Code ASC");
        } else {
            data = table.Rows.Lookup(["Active"], ["True"], 1000, "State Code ASC");
        }


        // sanitize data
        for (var i = 0; i < data.length; i++) {
            delete data[i]._CustomObjectKey;
            delete data[i]._CreatedDate;
        } //for


        // set headers
        Platform.Response.SetResponseHeader("Content-Type", "application/json");


        // return results
        Write(Stringify(data));


    } catch (error) {

        Write(Stringify({
            error: error
        }));

    }
</script>