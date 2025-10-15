<script runat="server">
Platform.Load("core", "1.1.5");

function Write(str) {
    Platform.Response.Write(str + "<br>");
}

// Function to retrieve folders using WSProxy
function retrieveFolders(parentFolderId) {
    var prox = new Script.Util.WSProxy();
    var cols = ["ID", "Name"];
    var filter = {
        Property: "ParentFolder.ID",
        SimpleOperator: "equals",
        Value: parentFolderId
    };
    var data = prox.retrieve("DataFolder", cols, filter);
    return data.Results;
}

// Function to iteratively display the folder structure
function displayFolderStructure(startingFolderID) {
    var queue = [{id: startingFolderID, level: 0}]; // Initialize queue with the starting folder

    while (queue.length > 0) {
        var item = queue.shift(); // Dequeue the first item
        var folders = retrieveFolders(item.id); // Retrieve subfolders

        for (var i = 0; i < folders.length; i++) {
            var folder = folders[i];

            Write("- " + folder.Name + " (ID: " + folder.ID + ")");

            // Enqueue subfolders for processing, incrementing the level
            queue.push({id: folder.ID, level: item.level + 1});
        }
    }
}

var startingFolderID = "365415"; // Replace with your actual starting folder ID
displayFolderStructure(startingFolderID);
</script>
