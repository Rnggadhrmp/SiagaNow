# YOLO analysis for user reports

## Current state

The repositories were audited on 16 November 2026. No YOLO weights (`.pt`/`.onnx`), training dataset, class map, training/inference script, or separate inference service was found. Existing camera flood detections are a separate feature and are not used as per-report image analysis. Therefore, no real detection result or supported disaster class is claimed yet.

Laravel now creates a `pending` `report_ai_analyses` record for each new API report, stores evidence on the existing private disk, and optionally dispatches image analysis on the `ai` queue. Only JPG/JPEG/PNG/WEBP evidence is sent; videos remain stored but are skipped by the current image service. If the service is disabled or incomplete, no job is dispatched and status stays pending. Service errors preserve report and evidence and mark analysis failed. A worker must consume the `ai` queue after an endpoint is configured.

Mobile history and report success show analysis and admin verification status. The admin report detail displays status, model/version, time, confidence, class, bounding box coordinates and protected image previews. The existing `reports.manage` permission gates verification. Verification does not change official report status or publish/send alerts. AI results are private to authorized admins; mobile receives only lifecycle and verification statuses.

## Configuration

Set these values in the Laravel environment only after deploying a compatible service:

```dotenv
YOLO_REPORT_ENABLED=true
YOLO_REPORT_URL=https://your-internal-yolo-service/analyze
YOLO_REPORT_TOKEN=replace-with-secret
```

Keep `YOLO_REPORT_ENABLED=false` until the endpoint is deployed and tested. Use a private HTTPS endpoint and a secret managed outside source control. Run a worker that includes the `ai` queue, for example `php artisan queue:work --queue=ai,default --timeout=150`.

## Service request and response contract

Laravel sends one multipart `image` file with `report_id` and `evidence_index` fields. The image comes from private report storage and is not made public. A compatible service response has this shape (contract example only; it is not a detection result):

```json
{
  "model": {"name": "deployed-model-name", "version": "version-id"},
  "detections": [
    {"class_name": "class-from-trained-model", "confidence": 0.82,
     "bbox": {"x": 0.1, "y": 0.2, "width": 0.3, "height": 0.25}}
  ]
}
```

Bounding boxes use normalized coordinates from 0 to 1. Confidence must be in the same range. The class name must come from the deployed model's trained labels; the integration does not define or translate class labels.

## Still required for real inference

- A validated YOLO model and versioned weights.
- Dataset provenance, labels, supported class list, and evaluation results for flood/water, landslide/debris, road blockage, or building damage. Only evaluated classes should be enabled.
- A secured, reachable inference endpoint implementing the contract, plus a queue worker and operational monitoring.
- Review of privacy/retention rules for sending uploaded evidence to that service.
- End-to-end test using a known, labeled image and admin verification. Until then, do not enable the integration and do not use it for alerts.

No early warning or official notification is emitted by this workflow. Any alert remains a separate action by authorized staff based on verified information.
