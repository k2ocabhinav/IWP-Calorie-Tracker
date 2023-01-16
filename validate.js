const password = document.getElementById("password");
    const email = document.getElementById("email");
    const name = document.getElementById("name");
    function validate_email()
    {
        x = 1
        const list = email.classList;
        list.remove("correct");
        list.remove("wrong");
        const error = document.getElementById("eerror")
        error.innerHTML = '';
        var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        if (email.value.match(mailformat))
           list.add("correct");
        else
        {
            list.add("wrong");
            error.innerText = "Empty field or invalid email format";
            email.parentElement.append(error);
            x = 0
        }
        return x;
    }
    function validate_password()
    {
        x = 1
        const list = password.classList;
        list.remove("correct");
        list.remove("wrong");
        const error = document.getElementById("perror")
        error.innerHTML = '';
        var passformat = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
        if (password.value.match(passformat))
           list.add("correct");
        else
        {
            list.add("wrong");
            error.innerText = "Invalid Password Format. It must be between 6 to 20 characters and be a mix of uppercase and lowercase letters, digits and special charcaters";
            password.parentElement.append(error);
            x = 0
        }
        return x;
    }
    function validate_name()
    {
        x = 1
        const list = name.classList;
        list.remove("correct");
        list.remove("wrong");
        const error = document.getElementById("nerror")
        error.innerHTML = '';
        var nameformat = /^[A-Za-zÀ-ÿ ,.'-]+$/;
        if (name.value.match(nameformat))
           list.add("correct");
        else
        {
            list.add("wrong");
            error.innerText = "Name cannot have numbers. A single name is mandatory.";
            name.parentElement.append(error);
            x = 0
        }
        return x;
    }
    document.forms[0][0].addEventListener('keyup', validate_email)
    document.forms[0][1].addEventListener('keyup', validate_password)
    document.forms[0][2].addEventListener('keyup', validate_name)
    function validate()
    {
        if(validate_email() & validate_name() & validate_password())
            return false;
        else
            return true;
    }