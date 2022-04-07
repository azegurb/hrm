// button: '[['title' , 'class' , ['data-id="hello"']]]'
//
console.info('Button plugin working!');
var button = [];
function buttongenerator(buttons){
    if(Array.isArray(buttons)){
        buttons.forEach(function(properties){
            button.push('<button class="btn btn-'+ properties[1] +'" '+ properties[2] +'>'+properties[0]+'</button>');
        });
    }else{
        throw new Error('Propperties must be an array')
    }
    return button;
}