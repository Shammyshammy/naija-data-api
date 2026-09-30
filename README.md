# Naija Data API

![Tests](https://github.com/Shammyshammy/naija-data-api/actions/workflows/tests.yml/badge.svg)

A free, open-source REST API for Nigerian data; states, LGAs, banks, and public holidays. Built with **Laravel 13** and documented with **OpenAPI** (Scalar).

## 🔗 Live API

- **Base URL:** `https://comin-soonnn.com/api/v1`
- **Interactive docs:** `https://comin-soonnn.com/docs/api`

## ✨ Features

- 🗺️ **37 states** — all 36 states + FCT, with capital, region, coordinates
- 🏘️ **185 LGAs** (5 per state; expanding to all 774)
- 🏦 **35 banks** — commercial, microfinance, non-interest, merchant
- 📅 **Public holidays** — 2026 and 2027, with type and description
- ⚡ **Rate limiting** — 60 requests/minute per IP
- 🚀 **Response caching** — 5-minute cache on all GETs
- 📖 **Auto-generated docs** at `/docs/api` (Scalar UI)
- ✅ **28 automated tests** running on every push

## 🚀 Endpoints

### States
| Method | Endpoint | Description |
|---|---|---|
| GET | `/api/v1/states` | List all states (paginated) |
| GET | `/api/v1/states?region=South West` | Filter by region |
| GET | `/api/v1/states?search=lagos` | Search by name/capital/code |
| GET | `/api/v1/states/regions` | List all regions |
| GET | `/api/v1/states/{code}` | Get state by code (e.g. `RIV`) or slug (e.g. `rivers`) |
| GET | `/api/v1/states/{code}/lgas` | Get LGAs in a state |

### Banks
| Method | Endpoint | Description |
|---|---|---|
| GET | `/api/v1/banks` | List all banks (paginated) |
| GET | `/api/v1/banks?type=microfinance` | Filter by type |
| GET | `/api/v1/banks?search=access` | Search by name |
| GET | `/api/v1/banks/types` | List bank types |
| GET | `/api/v1/banks/{code}` | Get bank by CBN code (e.g. `044`) |

### Holidays
| Method | Endpoint | Description |
|---|---|---|
| GET | `/api/v1/holidays` | List all holidays (paginated) |
| GET | `/api/v1/holidays?year=2026` | Filter by year |
| GET | `/api/v1/holidays?type=religious` | Filter by type |
| GET | `/api/v1/holidays/years` | List available years |
| GET | `/api/v1/holidays/year/{year}` | All holidays for a year |

### System
| Method | Endpoint | Description |
|---|---|---|
| GET | `/api/v1/` | Welcome + endpoint index |
| GET | `/api/v1/health` | Health check |

## 📋 Response Format

Every response follows the same envelope:

```json
{
    "success": true,
    "message": "State retrieved successfully.",
    "data": { }
}
```

Paginated responses add `meta` and `links`:

```json
{
    "success": true,
    "message": "States retrieved successfully.",
    "data": [ ],
    "meta": {
        "current_page": 1,
        "per_page": 50,
        "total": 37,
        "last_page": 1
    },
    "links": {
        "first": "...",
        "prev": null,
        "next": null,
        "last": "..."
    }
}
```

Errors follow the same shape:

```json
{
    "success": false,
    "message": "Endpoint not found.",
    "errors": null
}
```

## 🧪 Example Usage

### cURL
```bash
curl https://comin-soonnn.com/api/v1/states/RIV
```

### JavaScript
```javascript
const response = await fetch('https://comin-soonnn.com/api/v1/states/RIV');
const { data } = await response.json();
console.log(data.name, data.capital);
```

### Python
```python
import requests

response = requests.get('https://comin-soonnn.com/api/v1/states/RIV')
state = response.json()['data']
print(f"{state['name']} — capital: {state['capital']}")
```

## ⚡ Rate Limits

- **60 requests per minute** per IP address
- Response headers include `X-RateLimit-Limit` and `X-RateLimit-Remaining`
- Exceeding the limit returns HTTP `429` with a JSON error

## 🚀 Local Development

```bash
git clone https://github.com/Shammyshammy/naija-data-api.git
cd naija-data-api
composer install
cp .env.example .env
php artisan key:generate
```

Configure MySQL in `.env`:

```env
DB_CONNECTION=mysql
DB_DATABASE=naija_data_api
DB_USERNAME=root
DB_PASSWORD=
```

Then:

```bash
php artisan migrate --seed
php artisan serve
```

- API: `http://127.0.0.1:8000/api/v1`
- Docs: `http://127.0.0.1:8000/docs/api`

## 🧪 Testing

```bash
php artisan test
```

## 📝 Roadmap

- [ ] Complete all 774 LGAs
- [ ] Add more banks (fintech, mobile money)
- [ ] Add airports and their codes
- [ ] Add Nigerian universities
- [ ] Add political wards
- [ ] API key support for higher rate limits

## 📝 License

MIT