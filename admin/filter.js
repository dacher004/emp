
function lettersonly(event) {
    var key = event.key;

    if (
        (key >= 'a' && key <= 'z') ||
        (key >= 'A' && key <= 'Z') ||
        event.keyCode == 8 || 
        event.keyCode == 32 || 
        event.keyCode == 9 
    ) {
        return true;
    } else {
        event.preventDefault();
        return false;
    }
}

function emailonly(event) {
    var key = event.key;
    var isShiftPressed = event.shiftKey;
    if (
        (key >= 'a' && key <= 'z') ||  
        (key >= 'A' && key <= 'Z') ||            
        (key >= '0' && key <= '9' && !isShiftPressed) || 
        key === 'Backspace' ||                   
        key === ' ' ||                            
        key === '@' ||                          
        (key === '.' && !isShiftPressed) ||       
        (key === '2' && isShiftPressed) || 
        event.keyCode == 9   
    ) {
        return true;
    } else {
        event.preventDefault();
        return false;
    }
}


