class ConfigParser extends Parser{

    static make(configInput, categories){
        return new Config(configInput.id, configInput.name, configInput.description, categories);
        
    }
}