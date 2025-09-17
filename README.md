# Campus Lost & Found API

A simple PHP API for IT SIA31 students to report and browse lost items found on campus.

## Features
- **View All Items:** Retrieve a list of all reported lost items.
- **Report an Item:** Add a new lost item to the list.

## Installation & Setup
1.  Install [XAMPP](https://www.apachefriends.org/index.html).
2.  Start the **Apache** module from the XAMPP Control Panel.
3.  Clone this repository into the `C:\xampp\htdocs\` folder.
4.  Access the API at `http://localhost/sia31-api/`.

## API Usage

### Get All Items
**Request:**
```
GET http://localhost/sia31-api/?action=get_items
```

**Response:**
```json
[
    {
        "id": 1,
        "item_name": "Water Bottle",
        "location_found": "Library",
        "description": "Blue Hydroflask"
    }
]
```

### Report a New Lost Item
**Request:**
```
POST http://localhost/sia31-api/?action=add_item
Content-Type: application/json

{
    "item_name": "Textbook",
    "location_found": "Room 301",
    "description": "Calculus 101"
}
```

**Response:**
```json
{
    "id": 2,
    "item_name": "Textbook",
    "location_found": "Room 301",
    "description": "Calculus 101"
}
```
