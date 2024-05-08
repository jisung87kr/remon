function initChart (el, type, labels, datasets, customOptions = {}){
  var defaultOptions = {
    responsive: true,
    plugins: {
      legend: {
        // display: false,
        position: 'bottom',
      },
      title: {
        display: false,
      }
    }
  };

  // 기본 옵션을 사용자 지정 옵션으로 덮어쓰기
  var options = Object.assign({}, defaultOptions, customOptions);

  let data = {
    labels: labels,
    datasets: datasets,
  }

  var config = {
    type: type,
    data: data,
    options: options,
  };

  return new Chart(el, config);
}
