
pragma solidity >=0.7.0 <0.9.0;

contract fakeProduct{
    
     address payable public owner;
     
      modifier onlyOwner {
        require(msg.sender == owner);
        _; 
    }
    
    
    // Seller : 0xBA11CeBA776D9d25423a45d493eAb3697b73Fbb1
    // Manufacturer : 0xB5e13B08D6f573Ef4aef74eAd2A6e228a0ed0f87
    
    struct product {
        string brand;
        string model;
        string description;
        string manufactuerName;
        string manufactuerLocation;
        string manufactuerTimestamp;
        bool sold;
        string owner;
        // string destination;
    }
    
    
    struct customer {
        string name;
        string customerAddress;
        string customerLocation;
    }
    
    
    struct seller {
        string name;
        string shopaddress;
    }
    
    struct manufacturer{
        string name;
        address manufacturerAddress;
    }



    // Mapping types are declared as mapping(_KeyType => _ValueType). Here _KeyType can be almost any type except 
    // for a mapping, a dynamically sized array, a contract, an enum and a struct. _ValueType can actually be any type, 
    // including mappings.
    
    mapping (string => product) private productArray ;
    mapping (string => customer) customerArray;
    mapping (string => seller) sellerArray;
    mapping (string => manufacturer) manufacturerArray;
    
    function addManufacturer(string memory name,address manufacturer_address ,string memory email) public {
        
        manufacturer memory newManufacturer;
        newManufacturer.name = name;
        newManufacturer.manufacturerAddress = manufacturer_address;
        manufacturerArray[email] = newManufacturer;
    }
    
    function addProduct(string memory code,string  memory brand,string  memory model, string  memory description, 
            string  memory manufactuerName ,string  memory manufactuerLocation ,
            string  memory manufactuerTimestamp,string  memory productOwner) public {
                
        product memory newproduct;    
        newproduct.brand = brand;
        newproduct.model = model;
        newproduct.description = description;
        newproduct.manufactuerName = manufactuerName;
        newproduct.manufactuerLocation = manufactuerLocation;
        newproduct.manufactuerTimestamp = manufactuerTimestamp;
        newproduct.owner=productOwner;
        newproduct.sold = false;
        productArray[code] = newproduct;
        
    }
    
    
    
    function addSeller(string memory name,string memory seller_address ,string memory email) public {
        
        seller memory newSeller;
        newSeller.name = name;
        newSeller.shopaddress = seller_address;
        sellerArray[email] = newSeller;
        
    }
    
    function addCustomer(string memory name,string memory email) public {
        
        customer memory newcustomer;
        newcustomer.name=name;
        customerArray[email]=newcustomer;
        
    }
    
    
    function purchase(string memory code, string memory name ) public returns( string memory){
        if (productArray[code].sold == true){
            string memory message = "Product already sold.!!!!!!!!!";
            return message;
        }
        else{
         
        productArray[code].sold = true;
        productArray[code].owner = name;
        string memory message = "Transaction completed";
        return message;
    }
    }
    
    function getProductDetails(string memory code) public view returns(string  memory ,string  memory , string  memory , 
            string  memory  ,string  memory ,string  memory, string memory){
                
                
        return    (productArray[code].brand ,productArray[code].model ,productArray[code].description, productArray[code].manufactuerName,
                    productArray[code].manufactuerLocation, productArray[code].manufactuerTimestamp,productArray[code].owner);//,productArray[code].owner);
        
    }
    
    function getCustomer(string memory email) public view returns(string memory){
        
        return customerArray[email].name;
    }
    
    
    function getSeller(string memory email) public view returns(string memory,string memory){
        
        return (sellerArray[email].name,sellerArray[email].shopaddress);
    }
    
     function getManufacturer(string memory email) public view returns(string memory,address ){
        
        return (manufacturerArray[email].name,manufacturerArray[email].manufacturerAddress);
    }
    
    function changeOwner(string memory code,string memory name) public {
        
        productArray[code].owner=name;
    }
    
    function getOwner(string memory code) public view returns(string memory){
        return productArray[code].owner;
    }
    
}





