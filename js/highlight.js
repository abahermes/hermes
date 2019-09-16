$("tr td span .searchTxt").text(function(index, text) {
    return text.replace("N/A, ", "");
});