# Story 7: 포인트 출금 요청 시스템

**Epic**: POINT-001
**Story ID**: POINT-007
**우선순위**: 🔴 높음
**예상 시간**: 3-4시간
**상태**: ⬜ 대기

---

## 📋 요구사항

- 사용자가 포인트 출금을 요청할 수 있음
- 출금 요청 시 관리자에게 실시간 알림
- 관리자가 출금 요청을 승인/거부할 수 있음
- 승인 시 자동으로 포인트 차감 및 처리 완료 상태로 변경

---

## 🗃️ 데이터베이스 설계

### 테이블: `point_withdrawal_requests`

| 컬럼명 | 타입 | 제약 | 설명 |
|--------|------|------|------|
| id | bigint | PK, AUTO_INCREMENT | 고유 ID |
| user_id | bigint | FK, NOT NULL | 요청 사용자 |
| amount | integer | NOT NULL | 출금 요청 포인트 |
| bank_name | string(50) | NOT NULL | 은행명 |
| account_number | string(100) | NOT NULL | 계좌번호 |
| account_holder | string(50) | NOT NULL | 예금주 |
| status | string(20) | NOT NULL | 상태 (pending, approved, rejected, completed) |
| requested_at | timestamp | NOT NULL | 요청일시 |
| processed_at | timestamp | NULLABLE | 처리일시 |
| processed_by | bigint | FK, NULLABLE | 처리 관리자 |
| admin_note | text | NULLABLE | 관리자 메모 |
| rejection_reason | text | NULLABLE | 거부 사유 |
| created_at | timestamp | NOT NULL | 생성일 |
| updated_at | timestamp | NOT NULL | 수정일 |

### Enum: `WithdrawalStatusEnum`

```php
enum WithdrawalStatusEnum: string
{
    case PENDING = 'pending';       // 대기중
    case APPROVED = 'approved';     // 승인됨
    case REJECTED = 'rejected';     // 거부됨
    case COMPLETED = 'completed';   // 완료됨 (입금 완료)
}
```

---

## 🚀 작업 항목 (Tasks)

### Task 1: DB 마이그레이션 및 모델

- [ ] 마이그레이션 파일 생성
  - [ ] `database/migrations/xxxx_create_point_withdrawal_requests_table.php`
  - [ ] 테이블 구조 정의
  - [ ] Foreign key 설정 (user_id, processed_by)
  - [ ] 인덱스 추가 (user_id, status, created_at)

- [ ] Enum 생성
  - [ ] `app/Enums/Point/WithdrawalStatusEnum.php`
  - [ ] label() 메서드 추가
  - [ ] color() 메서드 추가 (뱃지 색상)

- [ ] Model 생성
  - [ ] `app/Models/PointWithdrawalRequest.php`
  - [ ] `user()` 관계 메서드
  - [ ] `processedBy()` 관계 메서드 (관리자)
  - [ ] `$casts` 설정 (status → WithdrawalStatusEnum)
  - [ ] `$fillable` 설정
  - [ ] Scope: `pending()`, `approved()`, `rejected()`
  - [ ] Accessor: `status_label`, `status_color`

- [ ] User 모델 관계 추가
  - [ ] `withdrawalRequests()` 관계 메서드

### Task 2: 사용자 - 출금 요청 기능

- [ ] 컨트롤러 생성
  - [ ] `app/Http/Controllers/Mymapge/PointWithdrawalController.php`
  - [ ] `index()` - 출금 요청 내역
  - [ ] `create()` - 출금 요청 폼
  - [ ] `store()` - 출금 요청 제출
  - [ ] Validation:
    - amount: required, numeric, min:10000 (최소 출금액), max:available_point
    - bank_name: required, string, max:50
    - account_number: required, string, max:100
    - account_holder: required, string, max:50

- [ ] 뷰 생성
  - [ ] `resources/views/mypage/withdrawal/index.blade.php`
    - 출금 요청 내역 테이블
    - 상태별 필터 (전체, 대기중, 승인됨, 거부됨, 완료)
    - 출금 가능 포인트 표시
  - [ ] `resources/views/mypage/withdrawal/create.blade.php`
    - 출금 요청 폼
    - 출금 포인트 입력
    - 은행 정보 입력 (은행명, 계좌번호, 예금주)
    - 현재 보유 포인트 표시
    - 최소 출금액 안내 (10,000 포인트)
    - 출금 수수료 안내 (있는 경우)

- [ ] 라우팅
  - [ ] `routes/web.php` 추가
  - [ ] `GET /mypage/withdrawal` - 출금 내역
  - [ ] `GET /mypage/withdrawal/create` - 출금 요청 폼
  - [ ] `POST /mypage/withdrawal` - 출금 요청 제출

- [ ] 비즈니스 로직
  - [ ] 보유 포인트보다 많은 금액 요청 불가
  - [ ] 최소 출금액 미만 요청 불가
  - [ ] 대기중인 출금 요청이 있으면 신규 요청 불가 (선택)
  - [ ] 요청 성공 시 관리자 알림 발송

### Task 3: 관리자 알림 시스템

- [ ] Notification 클래스 생성
  - [ ] `app/Notifications/Point/WithdrawalRequested.php`
  - [ ] `via()`: ['database', 'mail'] (선택)
  - [ ] `toDatabase()`: 알림 데이터
  - [ ] `toMail()`: 이메일 내용 (선택)

- [ ] Event 생성 (선택)
  - [ ] `app/Events/Point/WithdrawalRequestCreated.php`
  - [ ] Listener에서 Notification 발송

- [ ] 알림 발송 로직
  - [ ] 출금 요청 생성 시 모든 관리자에게 알림
  - [ ] 관리자 조회: `User::role('admin')->get()`

- [ ] 관리자 알림 UI
  - [ ] 헤더 알림 아이콘에 뱃지 표시
  - [ ] 알림 클릭 시 출금 요청 상세 페이지로 이동

### Task 4: 관리자 - 출금 요청 관리

- [ ] 컨트롤러 생성/수정
  - [ ] `app/Http/Controllers/Admin/PointWithdrawalAdminController.php`
  - [ ] `index()` - 출금 요청 목록
    - 필터: status, user, date range
    - 정렬: 최신순, 요청액 많은 순
    - 페이지네이션
  - [ ] `show($id)` - 출금 요청 상세
  - [ ] `approve(Request $request, $id)` - 승인
  - [ ] `reject(Request $request, $id)` - 거부
  - [ ] `complete($id)` - 완료 처리 (입금 완료)

- [ ] 뷰 생성
  - [ ] `resources/views/admin/withdrawal/index.blade.php`
    - 출금 요청 목록 테이블
    - 상태별 탭 (전체, 대기중, 승인됨, 완료, 거부)
    - 필터 폼 (사용자명, 날짜, 상태)
    - 요약 카드 (총 요청, 대기중, 승인됨, 완료)
  - [ ] `resources/views/admin/withdrawal/show.blade.php`
    - 출금 요청 상세 정보
    - 사용자 정보 (이름, 이메일, 보유 포인트)
    - 출금 정보 (요청 포인트, 은행 정보)
    - 상태 변경 버튼 (승인/거부/완료)
    - 관리자 메모 입력
  - [ ] 승인/거부 모달
    - 거부 시 사유 입력 필수

- [ ] 라우팅
  - [ ] `routes/admin.php` 추가
  - [ ] `GET /admin/withdrawal` - 목록
  - [ ] `GET /admin/withdrawal/{id}` - 상세
  - [ ] `POST /admin/withdrawal/{id}/approve` - 승인
  - [ ] `POST /admin/withdrawal/{id}/reject` - 거부
  - [ ] `POST /admin/withdrawal/{id}/complete` - 완료

- [ ] 승인 처리 로직
  - [ ] 트랜잭션 시작
  - [ ] 출금 요청 상태 → APPROVED
  - [ ] 포인트 차감 (UserPoint 생성, type: DECREMENT)
  - [ ] processed_at, processed_by 업데이트
  - [ ] 사용자에게 알림 발송
  - [ ] 트랜잭션 커밋

- [ ] 거부 처리 로직
  - [ ] 출금 요청 상태 → REJECTED
  - [ ] rejection_reason 저장
  - [ ] processed_at, processed_by 업데이트
  - [ ] 사용자에게 알림 발송

- [ ] 완료 처리 로직
  - [ ] 출금 요청 상태 → COMPLETED
  - [ ] processed_at 업데이트
  - [ ] 사용자에게 알림 발송

### Task 5: 사용자 알림

- [ ] Notification 클래스 생성
  - [ ] `app/Notifications/Point/WithdrawalApproved.php`
  - [ ] `app/Notifications/Point/WithdrawalRejected.php`
  - [ ] `app/Notifications/Point/WithdrawalCompleted.php`

- [ ] 알림 발송 로직
  - [ ] 승인 시 → WithdrawalApproved
  - [ ] 거부 시 → WithdrawalRejected (거부 사유 포함)
  - [ ] 완료 시 → WithdrawalCompleted

### Task 6: 검증 및 보안

- [ ] 비즈니스 룰 검증
  - [ ] 최소 출금액 설정 (예: 10,000 포인트)
  - [ ] 최대 출금액 제한 (있는 경우)
  - [ ] 출금 수수료 계산 (있는 경우)
  - [ ] 대기중인 요청 중복 방지

- [ ] 권한 검증
  - [ ] 사용자는 자신의 출금 요청만 조회 가능
  - [ ] 관리자만 승인/거부/완료 처리 가능
  - [ ] Policy 클래스 생성 (선택)

- [ ] 예외 처리
  - [ ] 보유 포인트 부족
  - [ ] 이미 처리된 요청 재처리 방지
  - [ ] 잘못된 상태 전환 방지

---

## ✅ Acceptance Criteria

### 사용자 관점

- [ ] 사용자는 보유 포인트를 출금 요청할 수 있음
- [ ] 출금 시 은행 정보를 입력할 수 있음
- [ ] 출금 요청 내역을 조회할 수 있음
- [ ] 출금 요청 상태를 확인할 수 있음 (대기중, 승인됨, 거부됨, 완료)
- [ ] 거부된 경우 거부 사유를 확인할 수 있음
- [ ] 보유 포인트보다 많은 금액은 요청할 수 없음
- [ ] 최소 출금액 미만은 요청할 수 없음

### 관리자 관점

- [ ] 관리자는 출금 요청이 들어오면 즉시 알림을 받음
- [ ] 관리자는 모든 출금 요청을 조회할 수 있음
- [ ] 관리자는 출금 요청을 승인/거부할 수 있음
- [ ] 관리자는 승인된 요청을 완료 처리할 수 있음
- [ ] 거부 시 거부 사유를 필수로 입력해야 함
- [ ] 승인 시 자동으로 포인트가 차감됨
- [ ] 처리 내역 (처리일시, 처리자)이 기록됨

### 시스템 관점

- [ ] 트랜잭션으로 데이터 정합성 보장
- [ ] 중복 처리 방지
- [ ] 알림 발송 성공
- [ ] 포인트 차감 이력 기록

---

## 📁 영향받는 파일

### 생성할 파일

```
database/migrations/xxxx_create_point_withdrawal_requests_table.php
app/Enums/Point/WithdrawalStatusEnum.php
app/Models/PointWithdrawalRequest.php
app/Http/Controllers/Mymapge/PointWithdrawalController.php
app/Http/Controllers/Admin/PointWithdrawalAdminController.php
app/Notifications/Point/WithdrawalRequested.php
app/Notifications/Point/WithdrawalApproved.php
app/Notifications/Point/WithdrawalRejected.php
app/Notifications/Point/WithdrawalCompleted.php
resources/views/mypage/withdrawal/index.blade.php
resources/views/mypage/withdrawal/create.blade.php
resources/views/admin/withdrawal/index.blade.php
resources/views/admin/withdrawal/show.blade.php
```

### 수정할 파일

```
app/Models/User.php (withdrawalRequests 관계)
routes/web.php (마이페이지 라우트)
routes/admin.php (관리자 라우트)
resources/views/layouts/app.blade.php (알림 아이콘, 선택)
```

---

## 🧪 테스트 시나리오

### 단위 테스트

- [ ] PointWithdrawalRequest 모델 테스트
  - [ ] 관계 메서드 테스트
  - [ ] Scope 테스트
  - [ ] Accessor 테스트

### 기능 테스트

- [ ] 출금 요청 생성
  - [ ] 유효한 요청 성공
  - [ ] 보유 포인트 초과 요청 실패
  - [ ] 최소 출금액 미만 요청 실패
  - [ ] 필수 필드 누락 시 실패

- [ ] 출금 요청 승인
  - [ ] 승인 시 포인트 차감 확인
  - [ ] 상태 변경 확인
  - [ ] 알림 발송 확인

- [ ] 출금 요청 거부
  - [ ] 거부 사유 필수 확인
  - [ ] 포인트 유지 확인
  - [ ] 상태 변경 확인

### 수동 테스트

1. **사용자 출금 요청**
   - 로그인 → 마이페이지 → 포인트 → 출금 요청
   - 은행 정보 입력 및 금액 입력
   - 요청 완료 확인

2. **관리자 알림 수신**
   - 출금 요청 시 관리자 알림 확인
   - 알림 클릭 시 상세 페이지 이동 확인

3. **관리자 승인 처리**
   - 관리자 로그인 → 출금 관리
   - 출금 요청 상세 확인
   - 승인 처리 → 포인트 차감 확인
   - 사용자 알림 확인

4. **관리자 거부 처리**
   - 거부 사유 입력
   - 거부 처리 → 포인트 유지 확인
   - 사용자 알림 확인

---

## 🎨 UI/UX 가이드라인

### 상태별 색상

- **대기중 (PENDING)**: 🟡 노란색 (warning)
- **승인됨 (APPROVED)**: 🔵 파란색 (info)
- **거부됨 (REJECTED)**: 🔴 빨간색 (danger)
- **완료됨 (COMPLETED)**: 🟢 녹색 (success)

### 출금 요청 폼

- 간단하고 명확한 입력 필드
- 실시간 보유 포인트 표시
- 최소 출금액 안내 문구
- 은행 정보 입력 도움말

### 관리자 대시보드

- 대기중 요청 강조 표시
- 빠른 승인/거부 액션 버튼
- 사용자 정보 및 포인트 현황 표시

---

## 📌 비즈니스 룰

### 출금 제한

- **최소 출금액**: 10,000 포인트
- **최대 출금액**: 제한 없음 (또는 설정 가능)
- **출금 수수료**: 없음 (또는 설정 가능)
- **중복 요청**: 대기중인 요청이 있으면 신규 요청 불가 (선택)

### 처리 프로세스

1. 사용자 출금 요청 → **PENDING**
2. 관리자 승인 → **APPROVED** + 포인트 차감
3. 관리자 입금 완료 → **COMPLETED**

또는 거부:
1. 사용자 출금 요청 → **PENDING**
2. 관리자 거부 → **REJECTED**

---

## 🔗 관련 Story

- Story 1: User 모델 확장 (의존)
- Story 2: 마이페이지 포인트 조회 (의존)
- Story 4: 관리자 포인트 수기 차감 (유사 로직)

---

## ⏱️ 예상 작업 시간

| Task | 예상 시간 |
|------|----------|
| Task 1: DB 및 모델 | 30분 |
| Task 2: 사용자 출금 요청 | 1시간 |
| Task 3: 알림 시스템 | 30분 |
| Task 4: 관리자 관리 | 1.5시간 |
| Task 5: 사용자 알림 | 30분 |
| Task 6: 검증 및 보안 | 30분 |

**총 예상 시간**: 4시간

---

**최종 업데이트**: 2025-11-17
**버전**: 1.0
