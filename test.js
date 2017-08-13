var exec = require('child_process').exec;
var dependency_orderer = require('dependency-orderer');
var dependency_array;
exec('bower list -json', function (err, stdout, stderr) {
    if (err) return console.log(err);
    dependency_array = dependency_orderer(JSON.parse(stdout));
    // do what you need with your dependency_array
});
