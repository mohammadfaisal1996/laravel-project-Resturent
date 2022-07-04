const express = require( 'express' );
const app = express();
const mysql = require('mysql');

const http = require( 'http' );
const server = http.createServer( app );
const { Server } = require( "socket.io" );
const io = new Server( server );


var config = {
    user: "goldenus_dbgolden",
    database: "goldenus_golden_meal_db",
    password: "&,j-R1?n9?!7",
    host: 'localhost',//process.env.DB_HOSTNAME,

};
var connection = mysql.createConnection(config);
 connection.connect(error => {
  if (error) throw error;
  console.log("Successfully connected to the database.");
});





app.get("/NewOrder",(req,res)=>{
    
        var orderId =req.query.data;

         sql = 'select * from orders where id= ?  ';
            
            connection.query(sql, [orderId],function (error, results, fields)  {
                
                        io.emit( 'NewOrder', results);

            });
                 
              
           
        res.send("ok");
       
    
});





io.on( 'connection', ( socket ) => {
    
    

    // Orders
    
    
 
    
    
        socket.on( 'getOrdersDetails', ( orderID ) => {
            
             
             result = Object.values(orderID);
           
          


             let sql = 'SELECT JSON_ARRAYAGG(JSON_OBJECT("quantity",order_items.quantity,"itemPrice",order_items.itemPrice,"totalPrice",order_items.totalPrice,"item_image",order_items.item_image,"item_name_en",order_items.item_name_en,"item_name_ar",order_items.item_name_ar,"instruction",(select orders.instruction from orders where orders.id=order_items.order_id limit 1),"DropOffAddress",(select orders.DropOffAddress from orders where orders.id=order_items.order_id limit 1),"sub_local",(select user_addresses.sub_local from user_addresses,orders where orders.phone_number=user_addresses.user_phone and orders.DropOffAddress=user_addresses.title and user_addresses.user_phone=orders.phone_number limit 1) ,"order_addons",(select JSON_ARRAYAGG(JSON_OBJECT( "AddOns_Category_name",order_addons.AddOns_Category_name,"AddOns_name_en",add_ons_list.add_ons_list_en,"AddOns_name_en",add_ons_list.add_ons_list_ar ,"AddOns_price",order_addons.AddOns_price )) from order_addons join add_ons_list on add_ons_list.id=order_addons.AddOns_id where order_addons.order_item_id=order_items.id ) ))from order_items  where order_id=?';
            
            connection.query(sql, [result],function (error, results, fields)  {  
            
            let res=Object.values(results);
            let result = Object.values(res[0])[0];
            if(error === null ){
                io.emit( 'getOrdersDetails', result );
            }else{
                io.emit( 'getOrdersDetails', error );
            }
            });
            
            
            
        
         });
         
         
         

            socket.on( 'getPendingOrders', ( orderID ) => {
                    

                    
            var array =[];
            var sql;
            
        
            
            var status=orderID.status;

               
            
             sql = 'select * from orders where Status= ?  ';
            
            connection.query(sql, [status],function (error, results, fields)  {  
            
           
       
            if(error === null ){
            io.emit( 'getPendingOrders', results );
            }else{
            io.emit( 'getPendingOrders', error );
            }
            });
            
            
            
            
            });
    
    
    
    
    
    
    socket.on( 'disconnect', ( reason ) => {
        console.log( `user disconnected due to\n${reason}` );
    } );
    
    
    
    
} );

server.listen( 3400, () => {
    console.log( 'listening on *:3400 1' );
} );

