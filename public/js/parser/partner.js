class PartnerParser extends Parser{

    static make(partnerInput){
        return new Partner(partnerInput.name, 
                            partnerInput.image, partnerInput.link);
        
    }
}