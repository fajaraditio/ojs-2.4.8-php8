# Performance Optimizations & Database Indexing

This document outlines key database optimizations and recommended indexes for running Open Journal Systems (OJS) 2.4.8 on high-volume production journals.

---

## 1. Metrics Table Indexing (Views & Downloads)

### Problem
In journals with significant traffic or accumulated historical statistics, the `metrics` table frequently exceeds 1,000,000+ rows. 

When displaying article views and galley downloads on the Homepage, Issue Table of Contents, Archive, and Article View pages, OJS executes queries such as:

```sql
SELECT SUM(metric) AS metric 
FROM metrics 
WHERE assoc_id = ? 
  AND assoc_type = 260 
  AND context_id = ? 
  AND metric_type = 'ojs::counter';
```

Default upstream OJS 2.4.8 schema indexes on `metrics` include:
- `metrics_load_id (load_id)`
- `metrics_metric_type_journal_id (metric_type, context_id)`
- `metrics_metric_type_assoc_type_submission_id (metric_type, assoc_type, submission_id)`
- `metrics_metric_type_context_id_assoc_type (metric_type, context_id, assoc_type)`

None of these indexes lead with or include `assoc_id`. As a result:
- MySQL must scan **~180,000 rows** per single article/galley metric lookup.
- A single page with 15 articles and galleys triggers 30+ queries, examining **over 5,400,000 rows**.
- Response times degrade to **50–60+ seconds**, exhausting PHP-FPM worker pools and triggering HTTP 502 Bad Gateway / 504 Gateway Timeout errors.

### Recommended Index
Execute the following query on the journal database:

```sql
CREATE INDEX metrics_assoc_type_assoc_id ON metrics (assoc_type, assoc_id, metric);
```

### Benchmark Results
- **Rows examined per query:** Reduced from `179,532` to `46` (99.97% reduction).
- **Issue Archive page (`/issue/archive`):** Dropped from **50.52s** to **0.17s**.
- **Homepage (`/index`):** Dropped from **60s timeout** to **0.85s**.
- **Article View (`/article/view/...`):** Dropped to **0.21s**.
