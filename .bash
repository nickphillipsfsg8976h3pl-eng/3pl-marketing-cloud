#Marketing Cloud Bash Profile
echo '--- marketing cloud bash profile loaded ---'

# contstants
PROJECT="Marketing_Cloud/3PL"

#commands
function mc() {

    if [ $1 = "types" ]; then
        mcdev selectTypes --debug
        return 1
    fi

    if [ $1 = "get" ]; then
        mcdev retrieve $PROJECT $2 $3
        return 1
    fi

    # if [ $1 = "set" ]; then
    #     mcdev deploy
    #     return 1
    # fi
} 

#ollama
