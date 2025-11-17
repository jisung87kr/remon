# Epic: 포인트 시스템 구축

## 📋 개요

**Epic ID**: POINT-001
**생성일**: 2025-11-17
**상태**: 🟡 진행중
**담당자**: -
**예상 기간**: 8-12 시간 (출금 요청 기능 추가)

---

## 🎯 목표

인플루언서 마케팅 플랫폼에서 캠페인 완료 보상 및 포인트 관리 시스템을 완성합니다.

### 비즈니스 요구사항

- [x] 캠페인 등록 시 포인트 점수를 설정할 수 있음
- [x] 사용자들은 해당 캠페인을 수행하고 캠페인이 마감되면 포인트가 적립됨
- [ ] 관리자는 사용자들의 포인트를 확인하고 관리할 수 있어야함
- [ ] 포인트는 현금으로 수기로 전환하고 관리자페이지에서 소진처리를 해야함
- [ ] **[NEW]** 사용자가 포인트 출금을 요청할 수 있음
- [ ] **[NEW]** 출금 요청 시 관리자에게 알림이 전송됨

---

## 📊 현재 구현 상태

### ✅ 완료된 기능

- [x] DB 스키마 (`campaigns.use_benefit_point`, `campaigns.benefit_point`)
- [x] `user_points` 테이블 (포인트 이력 관리)
- [x] `PointTypeEnum` (INCREMENT, DECREMENT)
- [x] 캠페인 완료 시 자동 포인트 적립 로직
  - 파일: `app/Http/Controllers/Admin/CampaignApplicationAdminController.php:52-64`
  - 중복 적립 방지 포함

### ❌ 미구현 기능

- [ ] 마이페이지 포인트 조회 (현재 "준비중" 상태)
- [ ] 관리자 포인트 관리 UI
- [ ] 포인트 수기 차감 (현금 전환 처리)
- [ ] User 모델 헬퍼 메서드
- [ ] **[NEW]** 사용자 출금 요청 기능
- [ ] **[NEW]** 관리자 출금 요청 승인/거부
- [ ] **[NEW]** 출금 요청 알림 시스템

---

## 🚀 작업 항목 (Stories)

### Story 1: User 모델 확장 (기본 인프라)

**우선순위**: 🔴 높음
**예상 시간**: 30분
**상태**: ⬜ 대기

#### Tasks

- [ ] `app/Models/User.php` 수정
  - [ ] `points()` 관계 메서드 추가
  - [ ] `getTotalPointAttribute()` - 총 적립 포인트
  - [ ] `getUsedPointAttribute()` - 총 사용 포인트
  - [ ] `getAvailablePointAttribute()` - 잔여 포인트
  - [ ] `getExpiringSoonPointAttribute()` - 만료 예정 포인트 (30일 이내)

- [ ] `app/Models/UserPoint.php` 수정
  - [ ] `user()` 관계 메서드 추가
  - [ ] `campaign()` 관계 메서드 추가
  - [ ] Scope: `active()` (만료되지 않은 포인트)
  - [ ] Scope: `expired()` (만료된 포인트)

#### Acceptance Criteria

- User 모델에서 `$user->available_point` 호출 시 잔여 포인트 반환
- 만료된 포인트는 계산에서 제외

#### 파일 경로

```
app/Models/User.php
app/Models/UserPoint.php
```

---

### Story 2: 마이페이지 포인트 조회

**우선순위**: 🔴 높음
**예상 시간**: 1-2시간
**상태**: ⬜ 대기

#### Tasks

- [ ] 컨트롤러 생성
  - [ ] `app/Http/Controllers/Mymapge/PointMypageController.php` 생성
  - [ ] `index()` 메서드: 포인트 내역 리스트
  - [ ] 페이지네이션 (20개/페이지)
  - [ ] 필터링: type (적립/차감), 기간

- [ ] 뷰 구현
  - [ ] `resources/views/mypage/point.blade.php` 수정
  - [ ] 포인트 요약 카드
    - 총 적립 포인트
    - 사용 포인트
    - 잔여 포인트
    - 만료 예정 포인트
  - [ ] 포인트 내역 테이블
    - 일시, 구분 (적립/차감), 포인트, 설명, 캠페인명, 만료일
  - [ ] 빈 상태 UI (포인트 내역 없을 때)

- [ ] 라우팅
  - [ ] `routes/web.php`에 라우트 추가
  - [ ] 미들웨어: `auth:sanctum`, `verified`

#### Acceptance Criteria

- 사용자는 자신의 포인트 적립/차감 내역을 조회할 수 있음
- 만료 예정 포인트가 빨간색으로 표시됨
- 캠페인 연관 포인트는 캠페인명 링크 포함

#### 파일 경로

```
app/Http/Controllers/Mymapge/PointMypageController.php (생성)
resources/views/mypage/point.blade.php (수정)
routes/web.php (수정)
```

---

### Story 3: 관리자 - 사용자별 포인트 조회

**우선순위**: 🟡 중간
**예상 시간**: 1시간
**상태**: ⬜ 대기

#### Tasks

- [ ] 사용자 상세 페이지 수정
  - [ ] `resources/views/admin/user/general/show.blade.php` 수정
  - [ ] 포인트 요약 섹션 추가 (카드)
    - 총 적립, 사용, 잔여 포인트
  - [ ] 포인트 내역 테이블 추가
    - 일시, 구분, 포인트, 설명, 캠페인, 만료일

- [ ] 컨트롤러 수정
  - [ ] `app/Http/Controllers/Admin/GeneralUserAdminController.php`
  - [ ] `show()` 메서드에 포인트 데이터 전달
  - [ ] `$user->load('points')`

#### Acceptance Criteria

- 관리자는 특정 사용자의 포인트 현황을 확인할 수 있음
- 포인트 내역이 최신순으로 정렬됨

#### 파일 경로

```
resources/views/admin/user/general/show.blade.php (수정)
app/Http/Controllers/Admin/GeneralUserAdminController.php (수정)
```

---

### Story 4: 관리자 - 포인트 수기 차감 (현금 전환)

**우선순위**: 🔴 높음
**예상 시간**: 2시간
**상태**: ⬜ 대기

#### Tasks

- [ ] 컨트롤러 생성
  - [ ] `app/Http/Controllers/Admin/UserPointAdminController.php` 생성
  - [ ] `deduct(Request $request, User $user)` 메서드
    - Validation: point (required, numeric, min:1, max:available_point)
    - Validation: description (required, string, max:255)
    - UserPoint 레코드 생성 (type: DECREMENT)
    - 트랜잭션 처리

- [ ] 뷰 구현
  - [ ] 포인트 차감 모달 생성
    - `resources/views/admin/user/general/show.blade.php`에 모달 추가
    - 차감 포인트 입력
    - 차감 사유 입력 (필수)
    - 현재 잔여 포인트 표시
  - [ ] 차감 버튼 추가 (포인트 섹션)

- [ ] 라우팅
  - [ ] `routes/admin.php`에 라우트 추가
  - [ ] `POST /admin/users/{user}/points/deduct`

- [ ] 검증 로직
  - [ ] 잔여 포인트보다 많은 금액 차감 방지
  - [ ] 차감 사유 필수 입력
  - [ ] 성공/실패 메시지 표시 (Toast/Alert)

#### Acceptance Criteria

- 관리자는 사용자 포인트를 수기로 차감할 수 있음
- 차감 시 사유를 반드시 입력해야 함
- 잔여 포인트보다 많은 금액 차감 시 에러 표시
- 차감 내역이 user_points 테이블에 기록됨 (type: DECREMENT)

#### 파일 경로

```
app/Http/Controllers/Admin/UserPointAdminController.php (생성)
resources/views/admin/user/general/show.blade.php (수정)
routes/admin.php (수정)
```

---

### Story 5: 관리자 - 전체 포인트 현황

**우선순위**: 🟢 낮음
**예상 시간**: 2시간
**상태**: ⬜ 대기

#### Tasks

- [ ] 컨트롤러 확장
  - [ ] `app/Http/Controllers/Admin/UserPointAdminController.php`
  - [ ] `index()` 메서드: 전체 사용자 포인트 현황
  - [ ] 필터링: 최소/최대 포인트, 기간
  - [ ] 정렬: 잔여 포인트 많은 순/적은 순

- [ ] 뷰 생성
  - [ ] `resources/views/admin/point/index.blade.php` 생성
  - [ ] 포인트 통계 카드
    - 전체 적립 포인트
    - 전체 사용 포인트
    - 현재 잔여 포인트 합계
  - [ ] 사용자별 포인트 테이블
    - 사용자명, 이메일, 총 적립, 사용, 잔여, 마지막 적립일
  - [ ] 필터 폼 (기간, 포인트 범위)
  - [ ] 엑셀 내보내기 버튼

- [ ] 엑셀 내보내기
  - [ ] `app/Exports/UserPointsExport.php` 생성
  - [ ] Maatwebsite/Excel 사용

- [ ] 라우팅
  - [ ] `routes/admin.php`에 라우트 추가
  - [ ] `GET /admin/points`
  - [ ] 사이드바 메뉴 추가

#### Acceptance Criteria

- 관리자는 전체 사용자의 포인트 현황을 한눈에 볼 수 있음
- 포인트가 많은/적은 사용자 순으로 정렬 가능
- 엑셀로 내보내기 가능

#### 파일 경로

```
app/Http/Controllers/Admin/UserPointAdminController.php (수정)
resources/views/admin/point/index.blade.php (생성)
app/Exports/UserPointsExport.php (생성)
routes/admin.php (수정)
```

---

### Story 6: 포인트 만료 처리 (선택)

**우선순위**: 🟢 낮음
**예상 시간**: 1-2시간
**상태**: ⬜ 대기

#### Tasks

- [ ] Artisan Command 생성
  - [ ] `app/Console/Commands/ExpirePoints.php` 생성
  - [ ] 만료된 포인트 조회 (expired_at < now())
  - [ ] 만료 처리 로직
  - [ ] 로그 기록

- [ ] 스케줄러 등록
  - [ ] `app/Console/Kernel.php`에 등록
  - [ ] 매일 자정 실행

- [ ] 만료 예정 알림 (선택)
  - [ ] 7일 전 사용자에게 이메일/알림 발송
  - [ ] Notification 클래스 생성

#### Acceptance Criteria

- 만료일이 지난 포인트는 잔여 포인트 계산에서 제외됨
- 매일 자동으로 만료 처리됨

#### 파일 경로

```
app/Console/Commands/ExpirePoints.php (생성)
app/Console/Kernel.php (수정)
app/Notifications/PointExpiringSoon.php (생성, 선택)
```

---

### Story 7: 포인트 출금 요청 시스템

**우선순위**: 🔴 높음
**예상 시간**: 3-4시간
**상태**: ⬜ 대기

> **상세 문서**: [EPIC_POINT_WITHDRAWAL.md](./EPIC_POINT_WITHDRAWAL.md)

#### 개요

사용자가 보유 포인트를 현금으로 출금 요청하고, 관리자가 이를 승인/거부하는 시스템을 구축합니다.

#### 핵심 기능

1. **사용자 출금 요청**
   - 출금 포인트 및 은행 정보 입력
   - 최소 출금액 검증 (10,000 포인트)
   - 출금 요청 내역 조회

2. **관리자 알림**
   - 출금 요청 시 관리자에게 실시간 알림
   - Database & Email 알림 (선택)

3. **관리자 승인/거부**
   - 출금 요청 목록 조회
   - 승인 시 자동 포인트 차감
   - 거부 시 사유 입력 필수
   - 입금 완료 처리

4. **사용자 알림**
   - 승인/거부/완료 시 알림 발송

#### Tasks 요약

- [ ] DB 마이그레이션 (`point_withdrawal_requests`)
- [ ] `WithdrawalStatusEnum` 생성
- [ ] `PointWithdrawalRequest` 모델
- [ ] 사용자 출금 요청 기능 (Controller, View)
- [ ] 관리자 출금 관리 (Controller, View)
- [ ] 알림 시스템 (Notifications)
- [ ] 트랜잭션 및 검증 로직

#### Acceptance Criteria

- [ ] 사용자는 보유 포인트를 출금 요청할 수 있음
- [ ] 출금 요청 시 관리자에게 알림이 전송됨
- [ ] 관리자는 출금 요청을 승인/거부할 수 있음
- [ ] 승인 시 자동으로 포인트가 차감됨
- [ ] 거부 시 거부 사유를 입력해야 함
- [ ] 모든 처리 내역이 기록됨

#### 파일 경로

**생성**:
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

**수정**:
```
app/Models/User.php
routes/web.php
routes/admin.php
```

---

## 📁 영향받는 파일 목록

### 생성할 파일

```
app/Http/Controllers/Mymapge/PointMypageController.php
app/Http/Controllers/Mymapge/PointWithdrawalController.php
app/Http/Controllers/Admin/UserPointAdminController.php
app/Http/Controllers/Admin/PointWithdrawalAdminController.php
app/Exports/UserPointsExport.php
app/Enums/Point/WithdrawalStatusEnum.php
app/Models/PointWithdrawalRequest.php
app/Notifications/Point/WithdrawalRequested.php
app/Notifications/Point/WithdrawalApproved.php
app/Notifications/Point/WithdrawalRejected.php
app/Notifications/Point/WithdrawalCompleted.php
resources/views/admin/point/index.blade.php
resources/views/admin/withdrawal/index.blade.php
resources/views/admin/withdrawal/show.blade.php
resources/views/mypage/withdrawal/index.blade.php
resources/views/mypage/withdrawal/create.blade.php
database/migrations/xxxx_create_point_withdrawal_requests_table.php
app/Console/Commands/ExpirePoints.php
app/Notifications/PointExpiringSoon.php (선택)
```

### 수정할 파일

```
app/Models/User.php
app/Models/UserPoint.php
resources/views/mypage/point.blade.php
resources/views/admin/user/general/show.blade.php
app/Http/Controllers/Admin/GeneralUserAdminController.php
routes/web.php
routes/admin.php
app/Console/Kernel.php
```

---

## 🧪 테스트 계획

### 단위 테스트

- [ ] User 모델 헬퍼 메서드 테스트
  - [ ] `getTotalPointAttribute()`
  - [ ] `getAvailablePointAttribute()`
  - [ ] 만료된 포인트 제외 확인

### 기능 테스트

- [ ] 마이페이지 포인트 조회
  - [ ] 인증된 사용자만 접근 가능
  - [ ] 포인트 내역 정상 표시

- [ ] 관리자 포인트 차감
  - [ ] 잔여 포인트 초과 차감 방지
  - [ ] 차감 사유 필수 입력 검증
  - [ ] 트랜잭션 롤백 확인

### 수동 테스트 시나리오

1. **사용자 포인트 조회**
   - 로그인 → 마이페이지 → 포인트 메뉴
   - 적립/차감 내역 확인
   - 만료 예정 포인트 확인

2. **관리자 포인트 차감**
   - 관리자 로그인 → 사용자 관리 → 특정 사용자 상세
   - 포인트 차감 버튼 클릭
   - 차감 금액 및 사유 입력
   - 차감 완료 후 내역 확인

3. **포인트 통계 조회**
   - 관리자 로그인 → 포인트 관리
   - 전체 포인트 현황 확인
   - 필터링 및 정렬 테스트
   - 엑셀 내보내기

---

## 🎨 UI/UX 가이드라인

### 색상

- **적립 포인트**: 🟢 녹색 (success)
- **차감 포인트**: 🔴 빨간색 (danger)
- **만료 예정**: 🟡 노란색 (warning)

### 컴포넌트 재사용

- `.badge` - 포인트 타입 표시
- `.table` - 포인트 내역 테이블
- `.card` - 포인트 요약 카드
- `.modal` - 포인트 차감 모달

### 반응형 디자인

- 모바일: 테이블 → 카드 레이아웃 전환
- 태블릿/데스크탑: 테이블 유지

---

## 📌 참고 사항

### 관련 파일 위치

- **포인트 자동 적립 로직**: `app/Http/Controllers/Admin/CampaignApplicationAdminController.php:52-64`
- **포인트 테이블 마이그레이션**: `database/migrations/2024_01_28_205914_create_user_points_table.php`
- **캠페인 포인트 필드**: `database/migrations/2024_01_23_134932_create_campaigns_table.php:24-25`

### 주의 사항

- 포인트 계산 시 **만료된 포인트는 제외**해야 함
- 포인트 차감 시 **트랜잭션 처리** 필수
- 중복 적립 방지 로직 유지 (campaign_id 기준)
- 현금 전환 처리는 **수기 차감**으로만 가능 (자동화 없음)

---

## 🏁 완료 기준 (Definition of Done)

- [ ] 모든 Story 완료
- [ ] 코드 리뷰 완료
- [ ] 테스트 통과 (단위 + 기능)
- [ ] 관리자 및 사용자 수동 테스트 완료
- [ ] 문서 업데이트 (README, API 문서)
- [ ] Production 배포

---

## 📅 마일스톤

| 날짜 | 목표 | 상태 |
|------|------|------|
| Day 1 | Story 1, 2 완료 (User 모델 + 마이페이지) | ⬜ |
| Day 2 | Story 3, 4 완료 (관리자 조회 + 포인트 차감) | ⬜ |
| Day 3 | Story 7 완료 (출금 요청 시스템) | ⬜ |
| Day 4 | Story 5, 6 완료 + 테스트 (선택 기능) | ⬜ |

---

## 🔗 관련 문서

- [POINT.md](./POINT.md) - 전체 요구사항
- [EPIC_POINT_WITHDRAWAL.md](./EPIC_POINT_WITHDRAWAL.md) - Story 7 상세 문서 (출금 시스템)
- [README.md](./README.md) - 프로젝트 개요

---

**최종 업데이트**: 2025-11-17
**버전**: 1.0
