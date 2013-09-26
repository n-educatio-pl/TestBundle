Feature: Tom catches Jerry

  @ac
  Scenario: Tom finally eats Jerry
    Given cat Tom and alive mouse Jerry
    When Tom eats Jerry
    Then Jerry is no more...