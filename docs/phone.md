<style>
    .green-text {
        color: #009602;
    }
    .blue-text {
        color: #006ccc;
    }
    .yellow-text {
        color: #9e8a0e;
    }
    .red-text {
        color: #a50000;
    }
</style>

# Phone API

The following API is for editing, adding, and deleting phone numbers from the table. Also for retrieving phones by search

### <span class="blue-text">POST</span> API/phones/phone.php

**Data Passed** 

| Paramater     | Type           |Value  |Description |
| ------------- |:-------------: |------:|-----------:|
| `name`      | `String`         |`String` |  |
| `phone`      | `Number`        |`Number` | contains only numbers and must be a 7 digit or 10 digit number (with 1 automatically attached afterwards) |
| `type`      | `String`        |`String` |  |



**Data Returned**

```javascript
{
    success: true, //can be true or false
    code: 0, 
    message: "", //message depending on error if any
    content: {
        id: "234234kdfglkf" //created phone id
    }
}
```
### <span class="yellow-text">PATCH</span> API/phones/phone.php

**Data Passed** 

| Paramater     | Type           |Value  |Description |
| ------------- |:-------------: |------:|-----------:|
| `id`      | `String`         |`String` |  |
| `name`      | `String`         |`String` |  |


**Data Returned**

```javascript
{
    success: true, //can be true or false
    code: 0, 
    message: "", //message depending on error if any
    content: {
        id: "234234kdfglkf" //created phone id
        name: "James Smith"
    }
}
```
### <span class="red-text">DELETE</span> API/phones/phone.php

**Data Passed** 

| Paramater     | Type           |Value  |Description |
| ------------- |:-------------: |------:|-----------:|
| `id`      | `String`         |`String` | id of client  |

**Data Returned**

```javascript
{
    success: true, //can be true or false
    code: 0, 
    message: "", //message depending on error if any
    content: {
        id: "sdfsdf23234" //ID of deleted phone
    }
}
```

### <span class="green-text">GET</span> API/phones/phone.php

**Data Passed** 

| Paramater     | Type           |Value  |Description |
| ------------- |:-------------: |------:|-----------:|
| `id`      | `String`         |`String` | id of phone  |

**Data Returned**

```javascript
{
    success: true, //can be true or false
    code: 0, 
    message: "", //message depending on error if any
    content: {
        id: "sdfsdf23234", //ID of phone
        name: "James Smith",
        phone: "13334445555",
        type: "sms"
    }
}
```

# Mass Get API

### <span class="green-text">GET</span> API/phones/phones.php

**Data Passed** 

| Paramater     | Type           |Value  |Description |
| ------------- |:-------------: |------:|-----------:|
| `page`      | `Number`         |`Number` | |
| `limit`      | `Number`         |`Number` | |
| `column`      | `String`         |`name`, `phone`, `type`, `date_added` | Sort column |
| `sort`      | `String`         |`ASC`, `DESC` | |
| `strict`      | `Number`         |`1`, `2` | strict search |
| `criteria`      | `Array`         | [] | search criteria|

**Criteria Array**

| Paramater     | Type           |Value  |Description |
| ------------- |:-------------: |------:|-----------:|
| `column`      | `String`         |{`name`, `phone`, `type`, `date_added`} | |
| `rule`      | `String`         |`String` -> {`contains`, `exact`} <br> `Date/Number` -> {`greater`, `less`, `exact`} | search rule for column |
| `value`      | `String`         |`String` `Date` `Number` |  |

**Data Returned**

```javascript
{
    success: true, //can be true or false
    code: 0, 
    message: "", //message depending on error if any
    content: {
        count: 2,
        results: [
            {
                id: "dsfsdf23234234", //id of phone
                name: "James Smith",
                phone: "14445556666",
                type: "sms"
            },
            {
                id: "dsfsdf23234234", //id of phone
                name: "John Jones",
                phone: "44455556661",
                type: "voice mail"
            }
        ]
    }
}
```

### <span class="green-text">GET</span> www.slist.com/phonefetch?page=""&limit=""

**Data Passed** 

| Paramater     | Type           |Value  |Description |
| ------------- |:-------------: |------:|-----------:|
| `page`      | `Number`         |`Number` | |
| `limit`      | `Number`         |`Number` | |

**Data Returned**

```javascript
{
    success: true, //can be true or false
    code: 0, 
    message: "", //message depending on error if any
    content: {
        count: 2,
        results: [
            {
                id: "dsfsdf23234234", //id of phone
                name: "James Smith",
                phone: "14445556666",
                type: "sms"
            },
            {
                id: "dsfsdf23234234", //id of phone
                name: "John Jones",
                phone: "44455556661",
                type: "voice mail"
            }
        ]
    }
}
```