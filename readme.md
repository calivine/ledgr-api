# Ledgr API
*Alex Caloggero*

## Version 1.0.0

*Monthly Budget And Expense Tracking*

# API Documentation

### Base URL:
`https://api.ledgr.site`

## Endpoints

### Budget
This is an object representing a monthly budget - a category name, planned amount, and actual amount.
```
GET  /budget/:category/:period/:month/:year
GET  /budget
POST /budget
```

### Attributes
**category** string

Name of the budget category.